<?php

/**
 *
 * @property string $basePath
 */
class GitRepository extends CModel
{
    public $basePath = '';


    public function attributeNames()
    {
        return array('basePath');
    }

    public function rules()
    {
        return array(
            array('basePath', 'safe'),
        );
    }

    public function getCommits($limit=null)
    {
        $options = array('-z', '--date-order');
        if ($limit) {
            $options[] = '-' . $limit;
        }
        list($stdOut, $stdErr) = $this->runGitCommand('log', $options);

        $commits = array();
        foreach(explode("\0", $stdOut) as $commitData) {
            $commit = new GitCommit($commitData);
            $commits[$commit->sha] = $commit;
        }

        // add graph info
        $options[] = '--pretty=format:"%H"';
        $options[] = '--graph';

        list($stdOut, $stdErr) = $this->runGitCommand('log', $options);

        $sha = '';
        $nextCommit = '';
        foreach(explode("\0", $stdOut) as $commitData) {
            if (preg_match('/^(.*) ([0-9a-f]{40})\n?(.*)/m', $commitData, $matches)) {
                $sha = $matches[2];
                $commitData = $nextCommit . $matches[1];
                $nextCommit = $matches[3] . (empty($matches[3]) ? "" : "\n");
            }
            if (isset($commits[$sha])) {
                $commits[$sha]->treeGraph .= $commitData;
            }
        }

        return $commits;
    }

    public function getCommit($sha)
    {
        $options = array($sha);
        list($stdOut, $stdErr) = $this->runGitCommand('show', $options);

        $commit = new GitCommit($stdOut);
        return $commit;
    }

    protected function runGitCommand($gitCommand, $args=array())
    {
        $cmd = 'git ' . $gitCommand . ' ' . implode(' ', $args);

        $descriptorSpec = array(
           0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
           1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            //2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
           2 => array("pipe", "w")   // stderr
        );
        $env = array('GIT_DIR' => $this->basePath . '.git');

        $process = proc_open($cmd, $descriptorSpec, $pipes, $this->basePath, $env);

        if (is_resource($process)) {
            // $pipes now looks like this:
            // 0 => writeable handle connected to child stdin
            // 1 => readable handle connected to child stdout
            // Any error output will be appended to /tmp/error-output.txt

            /*fwrite($pipes[0], '<?php print_r($_ENV); ?>');*/
            fclose($pipes[0]);

            $stdOut = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            $stdErr = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            // It is important that you close any pipes before calling
            // proc_close in order to avoid a deadlock
            if (($exitCode = proc_close($process)) != 0) {
                throw new GitException('Git command failed. Exit Code: ' . $exitCode . ' - ' . $stdErr);
            }
        } else {
            throw new GitException('Git command failed.');
        }

        return array($stdOut, $stdErr);
    }
}

class GitException extends CException
{
    
}