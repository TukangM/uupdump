#!/bin/bash
php ./sta/packsgen.php
echo ""

./autofetch.sh 2>run-sta.log
