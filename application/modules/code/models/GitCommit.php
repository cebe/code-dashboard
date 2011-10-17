<?php
/**
 *
 */
class GitCommit extends CModel
{
    /**
     * @var git commit properties
     */
    public $sha;
    public $date;
    public $author;
    public $summary;
    public $comment;
    public $merge;

    /**
     * @var part of the text-ascii-art-like-graph of this commit
     */
    public $treeGraph;

    public function __construct($data)
    {
        $data = explode("\n", $data);
        $lineCount = 0;
        $part = 'header';
        foreach($data as $line)
        {
            switch ($part)
            {
                case 'header':
                    if ($lineCount++ == 0) {
                        if (substr($line, 0, 6) != 'commit') {
                            throw new CException('Invalid Git Commit data: ' . $line);
                        }
                        $this->sha = substr($line, 7);
                    } elseif ($line == '') {
                        $part = 'body';
                        $lineCount = 0;
                    } else {
                        $line = explode(': ', $line);
                        $attribute = lcfirst($line[0]);
                        switch($attribute) {
                            case 'date':
                                $this->$attribute = strtotime($line[1]);
                            break;
                            default:
                                $this->$attribute = $line[1];
                        }
                    }
                break;
                case 'body':
                    if ($lineCount++ == 0) {
                        $this->summary = $line;
                        if (strlen($this->summary) > 50) {
                            $this->summary = substr($this->summary, 0, 47) . '...';
                        }
                        $this->comment = $line;
                    } else {
                        if (substr($line, 0, 4) == 'diff') {
                            $part = 'diff';
                            $lineCount = 0;
                        } else {
                            $this->comment .= "\n" . $line;
                        }
                    }
                break;
                case 'diff':
                    // todo
                break;
            }

        }
    }

    public function getShortSha()
    {
        return substr($this->sha, 0, 7);
    }

    public function attributeNames()
    {
        return array('sha', 'committer', 'author', 'comment');// todo: complete
    }

    public function rules()
    {
        return array(
            array('basePath', 'safe'),// todo: complete
        );
    }


}
