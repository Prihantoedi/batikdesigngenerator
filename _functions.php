<?php 

function cmToPixel($value){
	return value*37.795276;
}

function pixelToCm($value){
	return value*0.02645833;
}

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "database_batik_galih");

function DOMinnerHTML(DOMNode $element) 
{ 
    $innerHTML = ""; 
    $children  = $element->childNodes;

    foreach ($children as $child) 
    { 
        $innerHTML .= $element->ownerDocument->saveHTML($child);
    }

    return $innerHTML; 
} 

// function query
function query($query){
	global $conn; // $conn merujuk kepada variable global
	
	$result = mysqli_query($conn, $query);

	$rows = [];

	while($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	return $rows;
}

// Search algoritma
function cariAlgoritma($keyword){
	$query = "SELECT * FROM tbl_algoritma
			WHERE 
			algoritma_nama = '$keyword'
			";
	return query($query);
}

// Search motif
function cariMotif($keyword){
	$query = "SELECT DISTINCT tbl_motif.*
			FROM tbl_motif
			INNER JOIN jtbl_motif_karakter 	ON jtbl_motif_karakter.motif_id = tbl_motif.motif_id
			INNER JOIN tbl_karakter 		ON tbl_karakter.karakter_id		= jtbl_motif_karakter.karakter_id
			WHERE tbl_karakter.karakter_nama LIKE '%$keyword%' 
			OR tbl_motif.motif_nama LIKE '%$keyword%'
			";
	$rows =  query($query);
	return $rows;
}

function cariIdMotifdariHasil($hasilbatik_id){
	$query = "SELECT motif_id FROM jtbl_hasilbatik_motif
			INNER JOIN tbl_hasilbatik ON jtbl_hasilbatik_motif.hasilbatik_id = tbl_hasilbatik.hasilbatik_id
			WHERE jtbl_hasilbatik_motif.hasilbatik_id = '$hasilbatik_id'
			";
	$rows =  query($query);
	return $rows;	
}

// Search karakter dari motif
function cariKarakterMotif($id){
	$query = "SELECT tbl_karakter.karakter_nama FROM jtbl_motif_karakter
			INNER JOIN tbl_karakter ON jtbl_motif_karakter.karakter_id = tbl_karakter.karakter_id
			WHERE jtbl_motif_karakter.motif_id = '$id'
			";

	$lists = query($query);
	$li = [];
    foreach($lists as $list){
        $li[] = $list['karakter_nama'];
	}
	return $li;
}

function cariKarakterMotifBanyak($mtfId){
	$i = 1;

	foreach($mtfId as $mtf){
		$karakter = cariKarakterMotif($mtf['motif_id']);
		if($i == 1){
			$karakterAll = $karakter; $i++;
		}
		$karaktertambahan = array_diff($karakter, $karakterAll);
		$karakterAll = array_merge($karakterAll, $karaktertambahan);

	}
	return $karakterAll;
}



function karakterCetak($motif_karakter){  // buat katalog
	$i = 0; 
	$len = count($motif_karakter);
	$cetak = '';

	foreach($motif_karakter as $karakter){
		$cetak .= ucwords($karakter);
		if (!($i == $len - 1)) {
			$cetak .= ", ";
		} 
		$i++;
	} 
	return $cetak;
}

// cetak motif
function cetakMotif($motif, $motifSVGSize){
	$motifSVG = [];
	foreach ($motif as $mtf ) {
        $svg_file = file_get_contents('img/'.$mtf);   // Ambil konten
        $find_string   = '<svg';    // Cari posisi <svg>
        $position = strpos($svg_file, $find_string);    // Tandain posisi <svg>
        $svg_file_new = substr($svg_file, $position);   // Potong file jadi <svg>...</svg>
		
		// Ganti Panjang dan Lebar Motif
		$file = new DOMDocument();
		$file->loadXML($svg_file_new);

		$svg = $file->getElementsByTagName('svg')->item(0);
		
		$width = $svg-> getAttribute('width');
		$height = $svg-> getAttribute('height');
		$height = $motifSVGSize*$width/$height;
		$svg-> setAttribute('width',$motifSVGSize);
		$svg-> setAttribute('height',$height);
		
		$svg_file_new = $file->saveXML();
		$motifSVG[] = $svg_file_new;
    }
	return $motifSVG;
}

// ambil satu
function ambilSatu($motif, $motifSVGSize){
	$motifSVG = [];
	foreach ($motif as $mtf ) {
        $svg_file = file_get_contents('img/'.$mtf);   // Ambil konten
        $find_string   = '<svg';    // Cari posisi <svg>
        $position = strpos($svg_file, $find_string);    // Tandain posisi <svg>
		$svg_file_new = substr($svg_file, $position);   // Potong file jadi <svg>...</svg>
		// $svg_file_new-> setAttribute('fill', '#FF0000');
		// $motifSVG[] = $svg_file_new;
		
		// Ganti Panjang dan Lebar Motif
		$file = new DOMDocument();
		$file->loadXML($svg_file_new);

		$svg = $file->getElementsByTagName('svg')->item(0);
		
		$width = $svg-> getAttribute('width');
		$height = $svg-> getAttribute('height');
		$height = $motifSVGSize*$width/$height;
		$svg-> setAttribute('width',$motifSVGSize);
		$svg-> setAttribute('height',$height);
		$svg-> setAttribute('style', 'color: #FF0000');
		
		$svg_file_new = $file->saveXML();
		$motifSVG[] = $svg_file_new;
    }
	return $motifSVG;
}

// switch algoritma
function algorithmSwitch($algoritma,$motifJml){
	$file = '';
	$algjml = $algoritma.$motifJml;
	switch ($algjml) {
		case "berderet1":
			$file = '_algoritma1.js';
			break;
		case "berderet2":
			$file = '_algoritma2.js';
			break;
		case "berderet3":
			$file = '_algoritma3.js';
			break;
		case "spiral1":
			$file = '_algoritmaSpiral.js';
			break;
		case "spiral2":
			$file = '_algoritmaSpiral2.js';
			break;
		case "kotak1":
			$file = '_algoritmaKotak.js';
			break;
		case "kotak2":
			$file = '_algoritmaKotak2.js';
			break;
		case "wajik1":
			$file = '_algoritmaWajik.js';
			break;
		default	: $file = '_algoritma1.js';
	}
	return $file;
}

// konversi warna ke heksadesimal dan sebaliknya

function hexToColor($hexadecimal){
	$result = null;
	switch($hexadecimal){
		case null:
			$result = null;
			break;
		case "#fcfcfc":
			$result = "Putih";
			break;
		case "#cc8621":
			$result = "Yellow IGK";
			break;
		case "#7f732a":
			$result = "Yellow IRK";
			break;
		case "#b23424":
			$result = "Orange HR";
			break;
		case "#7a5844":
			$result = "Brown IRRD";
			break;
		case "#2e4c66":
			$result = "Blue 04B";
			break;
		case "#434f5b":
			$result = "Grey IRL";
			break;
		case "#2e1836":
			$result = "Violet 14R";
			break;
		case "#d3547b":
			$result = "Rose IR";
			break;
		case "#143d30":
			$result = "Green IB";
			break;
	}

	return $result;
}

function colorToHex($color){
	$result = null;
	switch($color){
		case null:
			$result = null;
			break;
		case "Putih":
			$result = "#fcfcfc";
			break;
		case "Yellow IGK":
			$result = "#cc8621";
			break;
		case "Yellow IRK":
			$result = "#7f732a";
			break;
		case "Orange HR":
			$result = "#b23424";
			break;
		case "Brown IRRD":
			$result = "#7a5844";
			break;
		case "Blue 04B":
			$result = "#2e4c66";
			break;
		case "Grey IRL":
			$result = "#434f5b";
			break;
		case "Violet 14R":
			$result = "#2e1836";
			break;
		case "Rose IR":
			$result = "#d3547b";
			break;
		case "Green IB":
			$result = "#143d30";
			break;
	}

	return $result;
}

 ?>