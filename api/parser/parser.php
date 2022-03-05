<?

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
use \Bitrix\Main\Loader;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if($_POST['data']){
	$data = $_POST['data'];
	
	switch($data['cmd']) {
		case 'add':
			
			$sections = Array();
			$ids = Array();
			
			$tree = CIBlockSection::GetTreeList(
				$arFilter=Array('IBLOCK_ID' => 1),
				$arSelect=Array()
			);
			
			while($section = $tree->GetNext()) {
				$sections[] = $section['NAME'];
				$ids[$section['NAME']] = $section['ID'];
			}
			
			$items = $data['items'];
		
			foreach($items as $item){
				if(!in_array($sections, $item['category'])){
					$bs = new CIBlockSection;
					$arFields = Array(
					  "ACTIVE" => 'Y',
					  "IBLOCK_SECTION_ID" => 0,
					  "IBLOCK_ID" => 1,
					  "NAME" => $item['category'],
					  "SORT" => 500);
					  
					$SECTION_ID = $bs->Add($arFields);  
				}else{
					$SECTION_ID = $ids[$item['category']];
				}
				
				
			}
		
			break;
	}
}

?>