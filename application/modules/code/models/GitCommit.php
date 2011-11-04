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
	public $summary;
	public $comment;
	public $author;
	public $authorDate;
	public $committer;
	public $commitDate;
    public $merge;
	public $tree;
	public $parents = array();
	public $diffs = array();

    /**
     * @var part of the text-ascii-art-like-graph of this commit
     */
    public $treeGraph;

    public function __construct($data, $raw=false)
    {
        $data = explode("\n", $data);
        $lineCount = 0;
        $part = 'header';
	    $diffs = array();
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
	                    if ($raw) {
	                        $line = explode(' ', $line);
	                        $attribute = lcfirst($line[0]);
		                    unset($line[0]);
		                    $line = implode(' ', $line);
	                    } else {
		                    $line = explode(': ', $line);
							$attribute = lcfirst($line[0]);
		                    $line = $line[1];
	                    }
	                    switch($attribute) {
		                    case 'author':
		                    case 'committer':
		                        // @todo: timezone is currently ignored here
			                    if ($raw && preg_match('/^(.* <.*?>) ([0-9]+) [\+|-][0-9]{4}$/', $line, $matches)) {
				                    $this->$attribute = $matches[1];
				                    $this->{($attribute=='committer')?'commitDate':'authorDate'} = $matches[2];
			                    } else {
			                        $this->$attribute = $line;
			                    }
		             		break;
		                    case 'parent':
			                    $this->parents[] = $line;
			                break;
							case 'date':
								$this->authorDate = strtotime($line);
							break;
							default:
						 	    $this->$attribute = $line;
						}
                    }
                break;
                case 'body':
                    if ($lineCount++ == 0) {
                        $this->summary = trim($line);
                        if (strlen($this->summary) > 50) {
                            $this->summary = substr($this->summary, 0, 47) . '...';
                        }
                        $this->comment = $line;
	                    break;
                    } else {
                        if (substr($line, 0, 4) == 'diff') {
                            $part = 'diff';
                            $lineCount = 0;
	                        $diffId = -1;
                        } else {
                            $this->comment .= "\n" . trim($line);
	                        break;
                        }
                    }
                case 'diff':
	                if (substr($line, 0, 4) == 'diff') {
		                $diffId++;
		                $diffs[$diffId] = $line . "\n";
	                } else {
		                $diffs[$diffId] .= $line . "\n";
	                }

                break;
            }

        }
	    foreach($diffs as $diffId => $diff)
	    {
		    $this->diffs[$diffId] = array(
			    'fileName' => 'file' . $diffId, // @todo: extract file names from diff
			    'diff' => $diff,
		    );
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
