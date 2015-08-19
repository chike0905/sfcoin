<?php
//引数
//$graph:$array["自分"]["友人"] = costの二次元配列
//$start:開始点の"自分"
//$goal:終了点の"友人"
//
//返値
//開始点から終了点の距離
function dijkstra($graph, $start, $goal) {
  $distance = array($start => 0);
  $visit = array($start);
  $predecessor = array();
  foreach( $graph as $node => $edge ) {
    $distance[$node] = pow(10, 10);
    $predecessor[$node] = $start;
  }
  foreach( $graph[$start] as $next => $cost ) {
    $distance[$next] = $cost;
  }
  while( !in_array($goal, $visit) ) {
    $current = null;
    foreach( array_diff(array_keys($graph), $visit) as $unvisited ) {
      if(!$current || $distance[$current] > $distance[$unvisited])
        $current = $unvisited;
    }
    $visit[] = $current;
    foreach( $graph[$current] as $next => $cost ) {
      if( $distance[$current] + $cost < $distance[$next] ) {
        $distance[$next] = $distance[$current] + $cost;
        $predecessor[$next] = $current;
      }
    }
  }
  $route = array($goal);
  while( !($start == $route[count($route) - 1]) ) {
    $route[] = $predecessor[$route[count($route) - 1]];
  }
  //echo implode(' -> ', array_reverse($route)) . "\n";
  return $distance[$goal];
}
