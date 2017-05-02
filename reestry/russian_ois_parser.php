<?php
header("Content-type: text/html;charset=utf-8");
function getPage($page, $query){
	$result = file_get_contents("http://www.tks.ru/db/ois?mode=search&second=x&page=" . $page . "&regnom=&description=" . urlencode(iconv("UTF-8", "windows-1251", $query)) . "&name=&namet=");
	$result = iconv("windows-1251", "UTF-8", $result);
	$pos = strpos($result, '</thead>');
	if (!$pos) return false;
	$result = substr($result, $pos + 8);
	$pos = strpos($result, '</table>');
	$result2 = substr($result, 0, $pos);

	$pos = strpos($result, 'Страницы:');
	$pages = substr($result, $pos);
	$pos = strpos($pages, '</p>');
	$pages = substr($pages, 0, $pos + 4);
	$pages = preg_replace('/\s+/', '', $pages);
	$result = $result2;
	if (substr_count($pages, '</b></p>') == 0 && $page < 5) $result .= getPage($page + 1, $query);
 	return $result;
}
echo getPage(1, "золотой");

?>