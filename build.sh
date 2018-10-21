#!/bin/sh

echo "<?php" > build/main.php

for file in src/*; do
    cat $file >> build/main.php
    echo "\n" >> build/main.php
done

sed -i.bak '1 ! s/<\?php//' build/main.php
