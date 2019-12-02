#!/bin/sh
if [ $# != 1 ]; then
    echo "引数にファイル名を指定してください"
    exit 1
fi

dir="$PWD/migrations/"
prefix=`date +%Y%m%d%H%M%S`
filename=${dir}${prefix}\_${1}.sql

# execute
touch ${filename}

echo "CREATE TABLE IF NOT EXISTS db.table ( \n    id int(11) NOT NULL AUTO_INCREMENT,\n    PRIMARY KEY (id) \n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;" > ${filename}
