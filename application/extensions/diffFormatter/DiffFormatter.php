<?php

require_once(Yii::getPathOfAlias('system.vendors.TextHighlighter.Text.Highlighter').'.php');
require_once(Yii::getPathOfAlias('system.vendors.TextHighlighter.Text.Highlighter.Renderer.Html').'.php');

class DiffFormatter extends COutputProcessor //CTextHighlighter
{
	public $language='php';

	/**
	 * Processes the captured output.
     * This method highlights the output according to the syntax of the specified {@link language}.
	 * @param string $output the captured output to be processed
	 */
	public function processOutput($output)
	{
		// run python script

		$cmd = dirname(__FILE__) . '/diff2html.py';

		$descriptorSpec = array(
		 0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
		 1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
		  //2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
		 2 => array("pipe", "w")   // stderr
		);
		$env = array();

		$process = proc_open($cmd, $descriptorSpec, $pipes, Yii::app()->runtimePath, $env);

		if (is_resource($process)) {
		  // $pipes now looks like this:
		  // 0 => writeable handle connected to child stdin
		  // 1 => readable handle connected to child stdout
		  // Any error output will be appended to /tmp/error-output.txt

		  fwrite($pipes[0], $output);
		  fclose($pipes[0]);

		  $stdOut = stream_get_contents($pipes[1]);
		  fclose($pipes[1]);

		  $stdErr = stream_get_contents($pipes[2]);
		  fclose($pipes[2]);

		  // It is important that you close any pipes before calling
		  // proc_close in order to avoid a deadlock
		  if (($exitCode = proc_close($process)) != 0) {
		      throw new GitException('diff command failed. Exit Code: ' . $exitCode . ' - ' . $stdErr);
		  }
		} else {
		    throw new GitException('diff command failed.');
		}

		//$stdOut;

		Yii::app()->getClientScript()->registerCss('diffFormat',
		   'td.diffpresent { width: 47%; }
			td.diffline    { width:  3%; }

			td.diffline, td.diffpresent {
				font-family: monospace;
				border-bottom: solid 1px #ddd;
			}

			.diffadded td, .diffchanged td, .diffdeleted td {
				background: #EEEEEE !important;
			}

			/** unmodified **/
			.diffponct {
				color: #CCCCCC;
			}
			.diffunmodified td {
				color: #555555;
			}

			/** added **/
			.diffadded td .diffponct {
				color: #77CC77;
			 }
			.diffadded td.diffpresent {
				color: #000000;
				background: #CCFFCC !important;
			}

            /** deleted **/
			.diffdeleted td .diffponct {
				color: #CC7777;
			 }
			.diffdeleted td.diffpresent {
				color: #000000;
				background: #FFCCCC !important;
			}

            /** modified **/
			.diffchanged td {
				color: #000000;
				background: #EEEEEE !important;
			}
			.diffchanged2 {
				background: #DDDDFF !important;
			}
			.diffchanged2 .diffponct {
				color: #7777CC;
			 }

			.diffbox-head {
				height: 50px;

			}
			.diffbox {
				margin: 5px auto;
				max-width: 1500px;
				font-size: 100%;
				border: solid 3px #000;
			}
			.diffbox tr td {
				padding: 0;
				margin: 0;
			}
			'
		);
		//CTextHighlighter::registerCssFile();
		//$final = preg_replace_callback('/<td class="diffpresent">(.*?)<\/td>/', array($this, 'highlighteCode'), $stdOut);

		echo '<div class="diffbox">';
		echo '   <div class="diffbox-head">HEAD</div>';
		echo $stdOut;
		echo '</div>';
		//$output=$this->highlight($output);
		//parent::processOutput($stdOut);
	}

	public function highlighteCode($code)
	{
		$options['use_language']=true;
		$options['tabsize']=4;//$this->tabSize;
		//$options['numbers']=($this->lineNumberStyle==='list')?HL_NUMBERS_LI:HL_NUMBERS_TABLE;

		$highlighter = empty($this->language) ? false : Text_Highlighter::factory($this->language);
		if ($highlighter !== false) {
			$highlighter->setRenderer(new Text_Highlighter_Renderer_Html($options));
			//$o=preg_replace('/<span\s+[^>]*>(\s*)<\/span>/','\1',$highlighter->highlight($content));
		}

		return '<td class="diffpresent">' . str_replace('&amp;', '&', str_replace('&amp;', '&', strip_tags($highlighter->highlight(strip_tags($code[1])), '<span>'))) . '</td>';
	}
}
