<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Code Dashboard Console',
	// application components
	'components'=>array(
		//*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(dirname(__FILE__)).'/data/testdrive.db',
            'initSQLs' => array("PRAGMA foreign_keys = ON;"),
		),
		// */
		// uncomment the following to use a MySQL database
		/*
        'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=code-dashboard',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		// */
	),

    'commandMap' => array(
        'migrate' => array(
            // alias of the path where you extracted the zip file
            'class' => 'application.extensions.yiiext.commands.migrate.EMigrateCommand',
            // this is the path where you want your core application migrations to be created
            'migrationPath' => 'application.migrations',
            // the name of the table created in your database to save versioning information
            'migrationTable' => 'migrations',
            // the application migrations are in a pseudo-module called "core" by default
            'applicationModuleName' => 'core',
            // define all available modules
            'modulePaths' => array(
/*                'admin'      => 'application.modules.admin.db.migrations',
                'user'       => 'application.modules.user.db.migrations',
                'yourModule' => 'application.any.other.path.possible',
                // ...*/
            ),
            // here you can configrue which modules should be active, you can disable a module by adding its name to this array
/*            'disabledModules' => array(
                'admin', 'anOtherModule', // ...
            ),*/
            // the name of the application component that should be used to connect to the database
            'connectionID'=>'db',
            // alias of the template file used to create new migrations
            //'templateFile'=>'application.db.migration_template',
        ),
    ),
);
