import store from "../../store/store";
import {TOASTER_MESSAGE, TOASTER_MODULE} from "../../store/types/types";



export const featureUnavailable=((feature)=>{
    store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message:feature+' feature not yet implemented.',ttl:5,type:'success'});
});
