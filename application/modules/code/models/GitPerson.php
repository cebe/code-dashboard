<?php

class GitPerson extends CModel
{
	/**
	 * @var git person properties
	 */
	public $name;
	public $email;

	public function __construct($name)
	{
		if (preg_match('/^(.*) <(.*)>$/', $name, $matches)) {
			$this->name = $matches[1];
			$this->email = $matches[2];
		}
	}


	public function getCommits()
	{
		// @todo: implement
	}

	public function attributeNames()
	{
		return array('name', 'email');
	}

	public function rules()
	{
		return array(
	        array('name,email', 'safe'),
		);
	}

}
