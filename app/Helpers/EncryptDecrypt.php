<?php

function id2hash($id){
  $hashids = new Hashids('yemarn123#',8);
      return  $hashids->encode($id);


}

function hash2id($hash){
 $hashids = new Hashids('yemarn123#',8);
      return  $hashids->decode($hash);

}


