<?php

use MailSender\controller\Process;

//gc_disable();
xdebug_start_gcstats();

require './vendor/autoload.php';

new Process();
