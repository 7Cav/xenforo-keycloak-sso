#!/bin/bash

XENFORO_DIR="./"
XENFORO_ZIP="./xenforo.zip"

function install() {
    if [[ ! -f $XENFORO_ZIP ]]; then
        echo "xenforo.zip not present, please dowload from the account panel"
        exit;
    fi

    echo "protecting xenforo zip by moving it temporarily into ./.github"
    mv $XENFORO_ZIP ./.github/

    if [ -f "admin.php" ]; then
        echo "Removing existing xenforo dir"
        git clean -x -f ;
    fi

    mv ./.github/xenforo.zip $XENFORO_ZIP


    unzip $XENFORO_ZIP -d $XENFORO_DIR
    mv $XENFORO_DIR/upload/** $XENFORO_DIR/
    rm -rf $XENFORO_DIR/upload
    echo "Xenforo unzipped into $XENFORO_DIR"

    echo "Setting correct file permissions"
    chmod 0755 $XENFORO_DIR;
    chmod 0777 $XENFORO_DIR/data $XENFORO_DIR/internal_data
}

if [ -f "admin.php" ]; then
    echo "Xenforo 2 seems to already unpacked"
    echo "Do you wish to wipe and unpack xenforo?"
    select yn in "Yes" "No"; do
        case $yn in
            Yes ) install; break;;
            No ) exit;;
        esac
    done
else
    install
fi
