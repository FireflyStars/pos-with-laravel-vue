<template>
 <nav class="navbar row">
<div class="div-logo">
        <img
            src="./../images/lcdt-logo.png"
            alt="Lcdt logo"
            class="img-fluid"
        />
</div>
<div class="test">

</div>


<div class="searchBar">
    <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="Recherche ..." value="" />
    <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
      <svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#666666" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
      </svg>
    </button>
  </div>

<div class="test">

</div>

<div class="rendez-vous-btn">

<button type="button" class="btn btn-orange2">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11 14.062V20H13V14.062C16.946 14.554 20 17.92 20 22H4C4.00003 20.0514 4.71119 18.1698 6 16.7083C7.28882 15.2467 9.0667 14.3058 11 14.062ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z" fill="white"/>
</svg>

Nouveau Rendez Vous
</button>
</div>
<div class="test">

</div>
<div class="devis-btn">
<button type="button" class="btn btn-orange">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M4 7.80985C4 7.05613 4 6.67926 4.10029 6.37461C4.29878 5.77169 4.77169 5.29878 5.37461 5.10029C5.67926 5 6.05613 5 6.80985 5C7.13404 5 7.29614 5 7.43364 5.04022C7.70521 5.11967 7.93042 5.31045 8.05343 5.56527C8.11571 5.69429 8.14236 5.85418 8.19566 6.17396L8.25 6.5C8.35527 7.13161 8.4079 7.44741 8.59795 7.66237C8.66164 7.73441 8.7354 7.79689 8.81694 7.84788C9.06021 8 9.38037 8 10.0207 8H13.9793C14.6196 8 14.9398 8 15.1831 7.84788C15.2646 7.79689 15.3384 7.73441 15.4021 7.66237C15.5921 7.44741 15.6447 7.13161 15.75 6.5L15.8043 6.17396C15.8576 5.85418 15.8843 5.69429 15.9466 5.56527C16.0696 5.31045 16.2948 5.11967 16.5664 5.04022C16.7039 5 16.866 5 17.1902 5C17.9439 5 18.3207 5 18.6254 5.10029C19.2283 5.29878 19.7012 5.77169 19.8997 6.37461C20 6.67926 20 7.05613 20 7.80985V17C20 18.8856 20 19.8284 19.4142 20.4142C18.8284 21 17.8856 21 16 21H8C6.11438 21 5.17157 21 4.58579 20.4142C4 19.8284 4 18.8856 4 17V7.80985Z" fill="#7E869E" fill-opacity="0.25"/>
<rect x="4" y="5" width="16" height="16" rx="2" stroke="white" stroke-width="1.2"/>
<path d="M16 2L16 6C16 6.94281 16 7.41421 15.7071 7.7071C15.4142 8 14.9428 8 14 8L10 8C9.05719 8 8.58579 8 8.29289 7.70711C8 7.41421 8 6.94281 8 6L8 2" stroke="white" stroke-width="1.2" stroke-linecap="round"/>
<path d="M9 14L15 14" stroke="white" stroke-width="1.2" stroke-linecap="round"/>
</svg>

Nouveau Devis</button>
</div>
</nav>

</template>

<script>
export default {
  name: "NavBar",
}
</script>

<style>
.test{
/* background-color: aqua; */
}

.navbar >div{
    padding: 0;
   display: flex;
  flex-direction: row;
  align-items: center;
}
.btn-orange{
    background-color:#E8581B;
    font-family: Open sans-serif;
    max-height: 38px;
    overflow: hidden;
    text-overflow: ellipsis
}
.btn-orange2{
    background-color:#E8581BB2;
    font-family: Open sans-serif;
    max-height: 38px;
    overflow: hidden;
    text-overflow: ellipsis;

}


.rendez-vous-btn{
    padding-top: 2rem;
/* padding-top: 10px;
height: fit-content; */
}
.transparent-search{
    background: transparent;
    border: #FFFFFF;
    border-radius: 25px;
}

.searchBar {
  width: 100%;
  display: flex;
  flex-direction: row;
  align-items: center;
  background: transparent;
  border: #FFFFFF;
  padding-left: 50px;
}

#searchQueryInput {
  width: 100%;
  height: 25px;
  background: none;
  outline: none;
  border: 0.5px solid #FFFFFF;
  /* border: #fff; */
  border-radius: 0.75rem;
  padding: 0 0 0 1rem;
  font-size: 1rem;
  color: #fff;
   overflow: hidden;
  text-overflow: ellipsis
}

#searchQuerySubmit {
  width: 3.5rem;
  height: 2.8rem;
  margin-left: -3.5rem;
  background: transparent;
  border: #fff;
  outline: none;
}

#searchQuerySubmit:hover {
  cursor: pointer;
}
.img-fluid{
    min-height: 54px;
    min-width: 120px;
    padding-left: 0px;
    justify-items: start;
}
.navbar{
     display: grid;
     grid-template-columns: 20% 40% 12% 1% 14% 0.5% 12% 0.5%;
     grid-template-rows: max-content;

     background: #070113;
     padding: 0 10px 0 0;
     background-color: black;
     width: 100%;
     max-height: 55px;


     /* justify-items: stretch; */

}
</style>
