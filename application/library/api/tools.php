<?php

// Color API
define('API_TOOLS_UNIXTIME', 'tools.unixtime');
define('API_COLOR_GET', 'color.get');
define('API_COLOR_REMOVE', 'color.remove');

switch ($action) {
    
    case API_TOOLS_UNIXTIME:
        $timestamp = intval($route[4]);
        $result = array();
        $result[] = date(DATE_RFC822,$timestamp);
        header('Content-Type: application/json');
        echo json_encode($result);
        break;
    
    case API_COLOR_GET:
        $screen = intval($route[4]);
        if ($screen < 1) { die('Please provide a screen id'); }
        $data = $db->data("SELECT c.id, c.x, c.y, pc.r, pc.g, pc.b, pc.alpha, pc.hex FROM color c LEFT JOIN project_color pc ON pc.id = c.color WHERE screen = " . $screen);
        header('Content-Type: application/json');
        echo json_encode($data);
        break;
    
    case API_COLOR_ADD:
        $screen = intval($route[4]);
        $x = intval($route[5]);
        $y = intval($route[6]);
        if ($screen < 1) { die('Please provide a screen id'); }
        
        // explicitly use a library color
        if (sizeof($route) < 9) {
            $color = intval($route[7]);
            if ($color < 1) { die('Please provide a reference color'); }
            $color = $db->single("SELECT * FROM project_color WHERE id = '" . $color . "' LIMIT 1");
            $r = $color['r'];
            $g = $color['g'];
            $b = $color['b'];
            $a = $color['alpha'];
            $hex = $color['hex'];
        } else {
            $r = intval($route[7]);
            $g = intval($route[8]);
            $b = intval($route[9]);
            $a = intval($route[10]);
            $hex = substr($route[11],0,6);
        }
        
        $screen = $db->single("SELECT id, project FROM screen WHERE id = '" . $screen . "'");
        
        $data = array(
            'created' => date('Y-m-d H:i:s'),
            'creator' => userid(),
            'project' => $screen['project'],
            'r' => $r,
            'g' => $g,
            'b' => $b,
            'alpha' => $a,
            'hex' => $db->escape($hex)
        );
        $result = 'EXISTING';
        $existing = $db->single('
            SELECT id 
            FROM project_color 
            WHERE project = ' . $screen['project'] . ' AND r = ' . $r . ' AND g = ' . $g . ' AND b = ' . $b . ' AND alpha = ' . $a . '
        ');
        $id = $existing['id'];
        if (!$existing) {
            $id = $db->insert('project_color', $data);
            $result = 'NEW';
        }
        
        // add reference to color
        $data = array(
            'created' => date('Y-m-d H:i:s'),
            'creator' => userid(),
            'screen' => $screen['id'],
            'color' => $id,
            'x' => $x,
            'y' => $y
        );
        $id = $db->insert('color', $data);
        $data['id'] = $id;
        $data['r'] = $r;
        $data['g'] = $g;
        $data['b'] = $b;
        $data['hex'] = $hex;
        $data['alpha'] = $a;
        $data['result'] = $result;
        
        header('Content-Type: application/json');
        echo json_encode($data);
        break;
        
}