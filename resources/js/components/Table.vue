<template>
    <side-bar></side-bar>
    <Main></Main>
     <form class="space-y-6" @submit.prevent="saveCible">
    <transition   enter-active-class="animate__animated animate__fadeIn"
                                      leave-active-class="animate__animated animate__fadeOut">
        <div class="container">
            <h3 class="color margin">E-MAILING</h3>
        <div class="row">
      <div class="col-md-6 col-18 d-flex align-self-stretch">
          <table class="table-borderless ">
              <thead>
              <tr >
                  <th class="px-5 py-3 padding"></th>
                      <th class="px-6 py-3 padding" v-for="item in status" :key="item.id">
                      <span class="text-left size">{{item}}</span>
                  </th>
                  <th class="center">
                      <span class="text-xs grey size emphasized" >E-mails sélectionnés</span>
                  </th>
              </tr>
              </thead>
  
              <tbody>
                  <tr scope="row"  v-for="item in industries" :key="item.id">
                   <th style="padding: 0px; font-size: small;">{{item}}</th>
                      <th v-for="i in status.length" >
                        <span style="padding: 19px;">
                            <input type="checkbox" @click="goToCreate()" :name="item+'_'+i" @change="onChange($event)" class=" px-6 padding radio">
                        </span>
                      </th>
                   <td class="px-4 padding butt-class" style="px-4 padding;">0 </td>  
                  </tr>
                      
  
              </tbody>
              <th></th>
               <th v-for="(i,j) in stat_length" :key="stat_length[i,j]">
                    <th></th>
                </th>
                  <label>Total</label>
        
                <tr>
                    <th v-for="(i,j) in stat_length" :key="stat_length[i,j]">
                          <th></th>
                      </th>
      
       <div class="row">
        <div>  <label class="type data">POUR RETRAVAILLER VOTRE LISTE :</label>   </div>
         <div class="type-click"> <button class="button type">CLIQUEZ ICI</button></div>
          </div>
         
         </tr>
          </table>
         
        
        </div>
      <div class="col-md-2 col-18 d-flex align-self-stretch">
          <!-- <div class="vl"></div> -->
      </div>
  
        <div class="col-md-4 col-18 column">
            <div>
                    <h1 class="size px-4 py-4 padding">CHARGER UN PRÉCÉDENT CIBLAGE</h1>
                    <table>
                        <tr>
                        <th class="size"><span class="close x-btn">&times;</span>  <input type="checkbox" class="radio" name="cible001">&nbsp;  Ciblage - Audit
                    </th>
                        <td class=" px-4 padding size-date">03/12/2021</td>
                        <th class="px-4 padding butt-class">50</th>
                        <tr class="line"></tr>
                        </tr>
                        <tr>
                        <th class="size"><span class="close x-btn">&times;</span>  <input type="checkbox" class="radio" name="cible002">&nbsp;  E-mail - Pluie
                    </th>
                        <td class=" px-4 padding size-date">11/11/2021
                    </td>
                        <th class="px-4 padding butt-class">538</th>
                        <tr class="line"></tr>
                    
                        </tr>
                        <tr>
                        <th class="size"><span class="close x-btn">&times;</span>  <input type="checkbox" class="radio" name="cible003">&nbsp;  E-mail - Entretien
                    </th>
                        <td class=" px-4 padding size-date" >08/11/2021 
                    </td>
                        <th class="px-4 padding butt-class">255</th>
                        <tr class="line"></tr>
                        </tr>
                </table>
            </div>
        <div class="left"> 
            <div> 
                <!-- <label class="bord emphasized">
                    <th>
                        <span class="font">1 761</span><span class="size-mail"> e-mails</span>
                    </th>
                </label> -->
            </div>
            <button class="button-valider type">VALIDER</button>
        </div>
    </div>
   
  </div >

  </div>

    </transition>
     </form>
</template>

<script>
    import {watch ,ref, computed,nextTick,onMounted} from 'vue';
    import useCompanies from "../composables/companies";
    import  SideBar from './layout/SideBar.vue'
    import Main from './Main.vue';
    import { reactive } from "vue";
    
    export default {
        components: {
            Main,
            SideBar
        },
        
        setup() {
            const form = reactive({
            'data': '',
            'data2': '',
        })


          const {indus_length, stat_length, industries, status, getCible, storeCible } = useCompanies()
          onMounted(getCible)
          console.log('data_stat', stat_length);
            const saveCible= async () => {
            await storeCible({...form});
        }
          return {
              form,
              status,
              industries,
              stat_length,
              indus_length,
              saveCible
          }
      },
       methods: {
      goToCreate: function () {
          console.log(name);
          console.log('check');
        },
         onChange(event) {
              var data = event.target;
              console.log(data.name);
          },
          onChange1(event) {
              var index = event.target;
              console.log(index.name);
          }
      }
    
}
</script>

<style scoped>
.color {
    color: orangered;
}
.margin {
    margin-bottom: 40px;
    margin-top: 35px;
}
.type-click {
    position: absolute;
    left: 50%;
}
  .h1 {
    color: #ff5c00;
      margin-bottom: 3%;
  
  }
  .padding {
      padding: 15px 12px;
  }
  .grey {
      color: grey;
  }
  .size {
      font-size: small;   
     
  }
  .size-mail {
      font-size: small;   
  }
  .font {
      font-weight: bold;
  }
  .size-date {
      font-size: x-small;   
  }
  .type { 
    font-size: x-small;   
    font-weight: bold;
  }
  .vl {
    border-left: 1px solid black;
    height: 480px;
    margin-left: 145px;
  
  }
  .emphasized { 
      font-style: italic; 
  }
    .radio{
    --checkbox-color: greenyellow;
    --checkmark-color: purple;
  }
 .radio {
      width: 15px;
      height: 15px; 
  }
    input[type='checkbox']:before {
        width: 20px;
        height: 20px;
        border-radius: 15px;
        top: -2px;
        left: -2px;
        position: relative;
        background-color: white;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 2px solid #FF4500;
        cursor : pointer; 
    }
  
      input[type='checkbox']:checked:before {
          width: 20px;
          height: 20px;
          border-radius: 15px;
          top: -2px;
          left: -2px;
          position: relative;
          background-color: #FF4500;
          content: '';
          display: inline-block;
          visibility: visible;
          border: 2px solid white;
          border: none !important;
      }
      .radio input[type=checkbox]:checked + label:after {
          border-color: #FF4500;
          border: none !important;
  
      }
      .butt-class {
          background-color: #D3D3D3; font-weight: normal;
      } 
      .line {
          border-bottom:1px; border-style: none solid dotted dashed;
      }
      .x-btn {
         color: #FF4500;
      }
      .button-click {
    background-color: white;
    color: orangered;
    border: 2px solid #e7e7e7;
   

  }
  .button {
    background-color: white;
    border: orangered 1px solid;
    color: orangered;
    cursor: pointer;
        width: 117px;
  }
      .button-valider {
    background-color: orangered;
    color: white;
    border: 2px solid orangered;
    width: 117px;
  }
  .data {
      position: absolute;
    left: 40%;
    display: block;
    width: 133px;
    text-align: end;
  }
  .custom-control-input:checked~.custom-control-label {
    color: #fff;
    border-color: orangered;
  }
  .center {
      text-align: center;
  }
  .bord {
    
    width: 117px;
    padding: 10px;
    border: 1px solid orangered;

  }
.column {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.left{
    text-align:end;
}
   
  </style>

  
