<?php

// ! SE FICHIER PERMET D'EXECUTER UN FICHIER PYTHON A PARTIR D'UN FICHIER PHP
// ! Il y aura des problèmes de chemin si il est executer depuis un autre endroit.

if($_GET['php2py'] == "scan"){
    $php2py_path = __DIR__;
    // exec python file in ../backend/scan_and_store.py
    exec("cd $php2py_path &&python ./scan_and_store.py");
}