<?php
  $recherche="q=";


  if ($nom!=NULL){
    $rnom="nomen_long:".$nom ;
    }
  else{
    $rnom=NULL;
  }
  if ($activite!=NULL){
    $ractivite="libapet:".$activite ;
    }
  else{
    $ractivite=NULL;
  }
  if ($cp!=NULL){
    $rcp="l6_normalisee:".$cp ;
    }
  else{
    $rcp=NULL;
  }
  if ($commune!=NULL){
    $rcommune="libcom:".$commune ;
    }
  else{
    $rcommune=NULL;
  }
  if ($categorie!=NULL){
    $rcategorie=$categorie ;
    }
  else{
    $rcategorie=NULL;
  }
  $arg=array($rnom,$ractivite,$rcp,$rcommune,$rcategorie);
  if($rnom != NULL){
    if($ractivite==NULL && $rcp==NULL && $rcommune==NULL && $rcategorie==NULL){
      $recherche.="(".$rnom.")";
    }
    else{
      $recherche.="(".$rnom.")+and+";
    }
  }

  if($ractivite != NULL){
    if($rcp==NULL && $rcommune==NULL && $rcategorie==NULL){
      $recherche.="(".$ractivite.")";
    }
    else{
      $recherche.="(".$ractivite.")+and+";
    }
  }
  if($rcp != NULL){
    if($rcommune==NULL && $rcategorie==NULL){
      $recherche.="(".$rcp.")";
    }
    else{
      $recherche.="(".$rcp.")+and+";
    }
  }
  if($rcommune != NULL){
    if($rcategorie==NULL){
      $recherche.="(".$rcommune.")";
    }
    else{
      $recherche.="(".$rcommune.")+and+";
    }
  }
  if($rcategorie != NULL){
    $recherche=substr($recherche,0,-5)."&refine.categorie=".$rcategorie;
  }
  $url="https://opendata.lillemetropole.fr/api/records/1.0/search/?dataset=base-sirene&rows=15&".$recherche;
  require("recherche.php");



?>
