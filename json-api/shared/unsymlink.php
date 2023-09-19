<?php
if(getenv('websiteDir', true)) {
    chdir(getenv('websiteDir', true));
} else if (isset($_SERVER['websiteDir'])) {
    chdir($_SERVER['websiteDir']);
}
