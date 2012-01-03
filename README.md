Code Dashboard [![Project status](http://stillmaintained.com/cebe/code-dashboard.png)](http://stillmaintained.com/cebe/code-dashboard)
==============

Code Dashboard claims to be a platform to keep track of your changes in your private Git repositories by providing a platform for code-review, commit listing and tagging and will link everything with your bugtracker.

code review is done here in a post-commit way, so your workflow goes on but nothing is deployed unseen later.

Status
======

I started the project just after checking out many code review tool of which none did cover my needs. It is in a very early development state so do not expect anything to work properly

I will increment minor version until 1.0 with not keeping backwards compatibility in mind.
All 1.0.x releases will be backwards compatible so update should not bring you any  trouble.
If there are bigger changes that break BC to 1.0.x I will increase the minor version.

Requirements
============

* Yii Framework 1.1.8
* Currently needs python to render commit diffs
* Smarty 3.1.x

Install
=======

* clone or download a copy of yii framework and place it aside with application and web directory, name it yii.
* Download a copy of Smarty and link its library dir to `application/vendors/Smarty`
* create `application/runtime` and `web/assets directories` and make them webserver-writeable
* run `git submodule update --init` from the base repository path

Contact
=======

E-Mail me: CeBe <mail@cebe.cc>
