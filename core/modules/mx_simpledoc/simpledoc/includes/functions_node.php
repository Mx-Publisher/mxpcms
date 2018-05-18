<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: functions_node.php,v 1.6 2008/06/03 20:14:11 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

// +--------------------------------------------------------------------+
// | DO NOT REMOVE THIS                                                 |
// +--------------------------------------------------------------------+
// | Nodes.php                                                          |
// | Tree management, all files/dirs operations.                        |
// +--------------------------------------------------------------------+
// | Author:  Cezary Tomczak [www.gosu.pl]                              |
// | Project: SimpleDoc                                                 |
// | URL:     http://gosu.pl/php/simpledoc.html                         |
// | License: GPL                                                       |
// +--------------------------------------------------------------------+

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

// Nodes management.
// Dependencies: IoFile, IoDir
// Author: Cezary Tomczak [www.gosu.pl]
// Project: SimpleDoc

class Node {
    var $id; // id of the node, empty for the root element
    var $path; // full path to file or directory
    var $io; // IoFile or IoDir object
    var $currFolder; // current folder, the node exists inside it, for the root element it points to itself
    var $level; // level of immersion, 0 for the root dir

    // this properties are overwritten on object creation, using global variables, see Node::Node()
    var $root = 'content'; // path to root element, without slash at the end
    var $sortFile = '.sort'; // name of the sort file
    var $chmodFile = 666;
    var $chmodDir = 777;

    var $error = false;

    function Node($id = '') {

        global $CONTENT, $SORT, $CHMOD_FILE, $CHMOD_DIR;
        $this->root = $CONTENT;
        $this->sortFile = $SORT;
        $this->chmodFile = $CHMOD_FILE;
        $this->chmodDir = $CHMOD_DIR;

        $this->id = $id;
        $this->path = $this->root.'/'.$this->id;
        $this->level = substr_count($this->id, '/');

        if ($this->id) {
            if (IoFile::exists($this->path)) {
                $this->io = new IoFile();
            } else if (IoDir::exists($this->path)) {
                $this->io = new IoDir();
            } else {
                return trigger_error("Node.Node() failed, node with id: '{$this->id}' doesn't exist", E_USER_ERROR);
            }
            $this->currFolder = dirname($this->path);
        } else {
            $this->currFolder = $this->root;
        }
    }

    // -------
    // ACTIONS
    // -------

    function moveUp() {
        if (!$this->id) { return trigger_error("Node.moveUp() failed, this action cannot be executed for the root element", E_USER_ERROR); }
        $nodes = $this->loadSort($this->currFolder);
        $key = array_search($this->path, $nodes);
        if ($key === false) { return trigger_error("Node.moveUp() failed, unknown error", E_USER_ERROR); }
        if ($key == 0) { return trigger_error("Node.moveUp() failed, current node is the first element", E_USER_ERROR); }
        $nodes2 = $nodes;
        $nodes2[$key-1] = $nodes[$key];
        $nodes2[$key] = $nodes[$key-1];
        $this->saveSort($this->currFolder, $nodes2);
    }
    function moveDown() {
        if (!$this->id) { return trigger_error("Node.moveDown() failed, this action cannot be executed for the root element", E_USER_ERROR); }
        $nodes = $this->loadSort($this->currFolder);
        $key = array_search($this->path, $nodes);
        if ($key === false) { return trigger_error("Node.moveDown() failed, unknown error", E_USER_ERROR); }
        if ($key == count($nodes) - 1) { return trigger_error("Node.moveDown() failed, current node is the last element", E_USER_ERROR); }
        $nodes2 = $nodes;
        $nodes2[$key+1] = $nodes[$key];
        $nodes2[$key] = $nodes[$key+1];
        $this->saveSort($this->currFolder, $nodes2);
    }
    function moveLeft() {
        if (!$this->id) { return trigger_error("Node.moveLeft() failed, this action cannot be executed for the root element", E_USER_ERROR); }
        if ($this->level <= 0) { return trigger_error("Node.moveLeft() failed, node doesn't have a parent", E_USER_ERROR); }
        $newCurrFolder = dirname($this->currFolder);
        $sort = $this->loadSort($newCurrFolder);
        $key = array_search($this->getCurrFolder(), $sort);
        if ($key === false) { return trigger_error("Node.moveLeft() failed, unknown error", E_USER_ERROR); }
        $Node = new Node($this->getIdByFullPath($newCurrFolder));
        if (in_array($this->getName(), $Node->getChildNames($Node->getCurrFolder()))) { return trigger_error("Node.moveLeft() failed, there is already w node with such name", E_USER_ERROR); }
        $new = $newCurrFolder.'/'.$this->getName();
        $this->io->move($this->path, $new);
        $this->fixSort($this->currFolder);
        array_splice($sort, $key, 0, $new);
        $this->saveSort($newCurrFolder, $sort);
        $this->Node($this->getIdByFullPath($new));
    }
    function moveRight() {
        if (!$this->id) { return trigger_error("Node.moveRight() failed, this action cannot be executed for the root element", E_USER_ERROR); }
        $nodes = $this->loadSort($this->currFolder);
        $key = array_search($this->path, $nodes);
        if ($key === false) { return trigger_error("Node.moveRight() failed, unknown error", E_USER_ERROR); }
        if ($key == count($nodes) - 1) { return trigger_error("Node.moveRight() failed, current node is the last element", E_USER_ERROR); }
        $Next = new Node($this->getIdByFullPath($nodes[$key+1]));
        if (!$Next->isFolder()) { return trigger_error("Node.moveRight() failed, next node is not a folder", E_USER_ERROR); }
        if (in_array($this->getName(), $Next->getChildNames($Next->getPath()))) { return trigger_error("Node.moveRight() failed, there is already a node with such name", E_USER_ERROR); }
        $sort = $Next->loadSort($Next->getPath());
        $new = $Next->getPath().'/'.$this->getName();
        $this->io->move($this->path, $new);
        $this->fixSort($this->currFolder);
        $sort = array_merge(array($new), $sort);
        $this->saveSort($Next->getPath(), $sort);
        $this->Node($this->getIdByFullPath($new));
    }
    function insert($name, $is_folder) {
        if ($this->id) { return trigger_error("Note.insert() failed, this action can be executed only for the root element", E_USER_ERROR); }
        if (in_array($name, $this->getChildNames($this->currFolder))) { return trigger_error("Node.insert() failed, there is already a node with such name", E_USER_ERROR); }
        $sort = $this->loadSort($this->currFolder);
        if ($is_folder) {
            IoDir::create($this->currFolder.'/'.$name, $this->chmodDir);
            IoFile::create($this->currFolder.'/'.$name.'/'.$this->sortFile, $this->chmodFile);
        } else {
            IoFile::create($this->currFolder.'/'.$name, $this->chmodFile);
        }
        $this->saveSort($this->currFolder, array_merge(array($name), $sort));
    }
    function insertBefore($name, $is_folder) {
        if (!$this->id) { return trigger_error("Node.insertBefore() failed, this action cannot be executed for the root element", E_USER_ERROR); }
        $Parent = new Node($this->getIdByFullPath($this->currFolder));
        if (in_array($name, $Parent->getChildNames($Parent->getCurrFolder()))) { return trigger_error("Node.insertBefore() failed, there is already a node with such name", E_USER_ERROR); }
        $sort = $this->loadSort($this->currFolder);
        $key = array_search($this->path, $sort);
        if ($key === false) { return trigger_error("Node.insertBefore() failed, unknown error", E_USER_ERROR); }
        if ($is_folder) {
            IoDir::create($this->currFolder.'/'.$name, $this->chmodDir);
            IoFile::create($this->currFolder.'/'.$name.'/'.$this->sortFile, $this->chmodFile);
        } else {
            IoFile::create($this->currFolder.'/'.$name, $this->chmodFile);
        }
        $a1 = array_slice($sort, 0, $key);
        $a3 = array_slice($sort, $key);
        $this->saveSort($this->currFolder, array_merge($a1, array($name), $a3));
    }
    function insertAfter($name, $is_folder) {
        if (!$this->id) { return trigger_error("Node.insertAfter() failed, this action cannot be executed for the root element", E_USER_ERROR); }
        $Parent = new Node($this->getIdByFullPath($this->currFolder));
        if (in_array($name, $Parent->getChildNames($Parent->getCurrFolder()))) { return trigger_error("Node.insertAfter() failed, there is already a node with such name", E_USER_ERROR); }
        $sort = $this->loadSort($this->currFolder);
        $key = array_search($this->path, $sort);
        if ($key === false) { return trigger_error("Node.insertAfter() failed, unknown error", E_USER_ERROR); }
        if ($is_folder) {
            IoDir::create($this->currFolder.'/'.$name, $this->chmodDir);
            IoFile::create($this->currFolder.'/'.$name.'/'.$this->sortFile, $this->chmodFile);
        } else {
            IoFile::create($this->currFolder.'/'.$name, $this->chmodFile);
        }
        $a1 = array_slice($sort, 0, $key+1);
        $a3 = array_slice($sort, $key+1);
        $this->saveSort($this->currFolder, array_merge($a1, array($name), $a3));
    }
    function insertInsideAtStart($name, $is_folder) {
        if (!$this->id) { return trigger_error("Node.insertInsideAtStart() failed, this action cannot be executed for the root element", E_USER_ERROR); }
        if (!$this->isFolder()) { return trigger_error("Node.insertInsideAtStart() failed, current node is not a folder", E_USER_ERROR); }
        if (in_array($name, $this->getChildNames($this->path))) { return trigger_error("Node.insertInsideAtStart() failed, there is already a node with such name", E_USER_ERROR); }
        $sort = $this->loadSort($this->path);
        if ($is_folder) {
            IoDir::create($this->path.'/'.$name, $this->chmodDir);
            IoFile::create($this->path.'/'.$name.'/'.$this->sortFile, $this->chmodFile);
        } else {
            IoFile::create($this->path.'/'.$name, $this->chmodFile);
        }
        $this->saveSort($this->path, array_merge(array($name), $sort));
    }
    function insertInsideAtEnd($name, $is_folder) {
        if (!$this->id) { return trigger_error("Node.insertInsideAtEnd() failed, this action cannot be executed for the root element", E_USER_ERROR); }
        if (!$this->isFolder()) { return trigger_error("Node.insertInsideAtEnd() failed, current node is not a folder", E_USER_ERROR); }
        if (in_array($name, $this->getChildNames($this->path))) { return trigger_error("Node.insertInsideAtEnd() failed, there is already a node with such name", E_USER_ERROR); }
        $sort = $this->loadSort($this->path);
        if ($is_folder) {
            IoDir::create($this->path.'/'.$name, $this->chmodDir);
            IoFile::create($this->path.'/'.$name.'/'.$this->sortFile, $this->chmodFile);
        } else {
            IoFile::create($this->path.'/'.$name, $this->chmodFile);
        }
        $this->saveSort($this->path, array_merge($sort, array($name)));
    }
    function rename($name, $is_folder) {
        if (!$this->id) { return trigger_error("Node.rename() failed, no id", E_USER_ERROR); }
        if ($this->isFolder()) {
            //die('isFolder: ' . $this->path . ' - ' . dirname($this->path). '/' . $name );
            IoFile::rename($this->path, dirname($this->path).'/' . $name);
            $this->fixSort($this->currFolder);
        } else {
            //die('isDoc: ' . $this->path . ' - ' . dirname($this->path). '/' . $name );
            IoDir::rename($this->path, dirname($this->path).'/' . $name);
            $this->fixSort($this->currFolder);
        }
    }
    function remove() {
        if (!$this->id) { return trigger_error("Node.remove() failed, this action cannot be executed for the root element", E_USER_ERROR); }
        if ($this->isFolder()) {
            if (count($this->getChildNames($this->path))) { return trigger_error("Node.remove() failed, there are still other nodes in the folder", E_USER_ERROR); }
            IoFile::delete($this->path.'/'.$this->sortFile);
            IoDir::delete($this->path);
            $this->fixSort($this->currFolder);
        } else {
            IoFile::delete($this->path);
            $this->fixSort($this->currFolder);
        }
    }

    // ----
    // INFO
    // ----

    function isDoc() { return is_a($this->io, 'IoFile'); }
    function isFolder() { return is_a($this->io, 'IoDir'); }
    function getPath() { return $this->path; }
    function getCurrFolder() { return $this->currFolder; }
    function getName() {
        if (!$this->id) return null;
        return substr($this->path, strlen(dirname($this->path).'/'));
    }

    // ----------
    // HELP FUNCS
    // ----------

    function getChildNames($folder) {
        $names = IoDir::read($folder, array($this->sortFile));
        foreach ($names as $k => $path) {
            $names[$k] = substr($path, strlen(dirname($path).'/'));
        }
        return $names;
    }
    function getIdByFullPath($path) {
        return substr($path, strlen($this->root.'/'));
    }

    // ----
    // SORT
    // ----

    // returns array of given folder nodes (full paths)
    function loadSort($folder) {
        $nodes = IoDir::read($folder, array($this->sortFile));
        $sort = IoFile::read($folder.'/'.$this->sortFile);
        $sort = $sort ? explode("\n", $sort) : array();
        foreach ($sort as $k => $v) { $sort[$k] = trim($v); }
        $sort2 = array();
        foreach ($sort as $node) {
            $node = $folder.'/'.$node;
            if (in_array($node, $nodes)) {
                $sort2[] = $node;
            }
        }
        foreach ($nodes as $node) {
            if (!in_array($node, $sort2)) {
                $sort2[] = $node;
            }
        }
        return $sort2;
    }
    // $arr can contain full paths or only node name
    function saveSort($folder, $arr) {
        $sort = array();
        foreach ($arr as $node) {
            $sort[] = strpos($node, '/') !== false ? substr($node, (int)strrpos($node, '/')+1) : $node;
        }
        IoFile::write($folder.'/'.$this->sortFile, implode("\r\n", $sort));
    }
    function fixSort($folder) {
        $nodes = $this->loadSort($folder);
        $this->saveSort($folder, $nodes);
    }
}
?>