<?php
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=REKAP_TANGGUNGAN_".date("Y-m-d_h.i.s").".csv");
header("Pragma: no-cache");
header("Expires: 0");
// echo json_encode($dataTagihan);exit;
$cols=Array(
    "SPP_1", "SPP_2", "SPP_3", "SPP_4", "SPP_5", "SPP_6", "SPP_7", "SPP_8", "SPP_9", "SPP_10", 
    "UAS_1", "UAS_2", "UAS_3", "UAS_4", "UAS_5", "UAS_6", "UAS_7", "UAS_8", "UAS_9", "UAS_10", 
    "UTS_1", "UTS_2", "UTS_3", "UTS_4", "UTS_5", "UTS_6", "UTS_7", "UTS_8", "UTS_9", "UTS_10", 
    "HER_1", "HER_2", "HER_3", "HER_4", "HER_5", "HER_6", "HER_7", "HER_8", "HER_9", "HER_10", 
    "HER", "OPSPEK", "UG", "KKN", "SKRIPSI", "WISUDA"
);

echo '"NIM","Nama",';
foreach($cols as $col){
    echo "\"".$col."\",";
}
echo "\n";
foreach($dataTagihan as $item){
    //map tanggungan
    $tanggungan=Array();
    foreach($item['tanggungan'] as $tgg){
        if(in_array($tgg['tgg_jenis'],['SPP','UTS','UAS','HER'])){
            $tanggungan[$tgg['tgg_jenis']."_".$tgg['tgg_semester']]=$tgg['tgg_nominal'];
        }else{
            $tanggungan[$tgg['tgg_jenis']]=$tgg['tgg_nominal'];
        }
    }
    //map pembayaran
    $pembayaran=Array();
    foreach($item['pembayaran'] as $pmb){
        if(in_array($pmb['pmb_jenis'],['SPP','UTS','UAS','HER'])){
            $pembayaran[$pmb['pmb_jenis']."_".$pmb['pmb_semester']]=$pmb['pmb_nominal'];
        }else{
            $pembayaran[$pmb['pmb_jenis']]=$pmb['pmb_nominal'];
            }
    }
    echo "\"".addslashes($item['mhs_nim'])."\",\"".addslashes($item['mhs_nama'])."\",";
    foreach($cols as $col){

        if( isset($tanggungan[$col]) && isset($pembayaran[$col]) ){
            $delta=$pembayaran[$col]-$tanggungan[$col];
            if($delta==0){
                $tagihan="LUNAS";
            }elseif($delta>0){
                $tagihan=$delta;
            }else{
                $tagihan=$delta;
            }
        }elseif(isset($tanggungan[$col])){
            $tagihan=0-$tanggungan[$col];
        }elseif(isset($pembayaran[$col])){
            $tagihan=$pembayaran[$col];
        }else{
            $tagihan="";
        }
        echo "\"".$tagihan."\",";
    }
    echo "\n";
}
?>