<?php
  class ItemsGroups extends ArrayObject{
    public function __construct($mysqli) {
      $result = $mysqli->query("SELECT `itemsgroups`.*, `articles`.`posted` as `article_posted` FROM `itemsgroups` LEFT OUTER JOIN `articles` ON `articles`.`id`=`itemsgroups`.`article_id`");
      while($row = $result->fetch_assoc()){
        $row['children'] = array();
        $this[$row['id']] = $row;
      }
      return $this;
    }
    function getTree() {
      $tree = array();
      foreach ($this as $id => &$node) {
        if (!$node['parent']){
          $tree[$id] = &$node;
        }else{ 
          $parent = &$this[$node['parent']];
          $parent['children'][$id] = &$node;
        }
      }
      return $tree;
    }
  }