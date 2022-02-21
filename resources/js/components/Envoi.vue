<template>
<SideBar />
<Main />

<div class="container">
      <h3 class="color margin">ENVOI</h3>

<div class="row">

 <div class="col-sm-5 col-md-4 col-lg-4 d-flex align-self-stretch">
    <h6 class="align1 color">TEST</h6>
  <p class="p-size1">Testez votre campagne avant envoi.</p>
 <div class="div-input"> <input type="text" class="input-text"><i class="bi bi-plus plus-but"></i> </div>
    <div>
        <label class="l-size">CARNET D’ADRESSES :</label>
    </div>
    <div class="div-bot">
     <td> <th class="size"><span class="close x-btn">&times;</span>  <input type="radio" class="radio" name="cible003"> test@test.test</th>
   </td>
    <div class="div-bot1">
   <td> <th class="size"><span class="close x-btn">&times;</span>  <input type="radio" class="radio" name="cible003"> test@test.test</th>
   </td>
    </div>
    <div>
          <button class="button-tester type">TESTER</button>

    </div>
    </div>
    
    <div class="vl"></div>
</div>

 <div class="col-sm-5 col-md-4 col-lg-4 d-flex align-self-stretch">
    <h6 class="align2 color">ENVOI IMMÉDIAT</h6>
  <p class="p-size2">Envoyez votre campagne immédiatement.</p>
 <div style="position: absolute;
    top: 305px;">
<div class="row" style="font-size: x-small;">
    <div>  <th>Lun. 06 déc. 2021
  </th>
    </div>
    <div style="position: absolute;
left: 266px;">
      <th>14:00</th>
    </div>
       </div>
      <tr class="line"></tr>
  <label class="bord emphasized">
                <th>
                <div class="font">1 761</div><div class="size-mail"> e-mails</div>
                </th>
                </label>
          <button class="button-envoyer type">ENVOYER</button>
    </div>
    <div class="vl2"></div>

</div>

 <div class="col-sm-5 col-md-4 col-lg-4 d-flex align-self-stretch">
    <h6 class="align3 color">ENVOI DIFFÉRÉ</h6>
  <p class="p-size3">Programmez l’envoi de votre campagne.</p>
<label class="bord1 emphasized">
                <th>
                <div class="font">1 761</div><div class="size-mail"> e-mails</div>
                </th>
                </label>
          <button class="button-programmer type">PROGRAMMER</button>
    </div>
    <div class="vl2"></div>
</div>






</div>      
</template>

<script>
 import SideBar from './layout/SideBar.vue'
 import Main from './Main.vue';
export default {
components: {
    Main,
    SideBar,
  }
}
</script>

<style>



</style>