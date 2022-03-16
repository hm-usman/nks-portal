<template>
    <section>
            <h6>
                {{this.website}}
            </h6>
        <div class="row mb-3">
            <div class="col-md-6">
                <textarea rows="10" class="form-control" placeholder="Enter Ad Code Wordpress" v-model="wordpress"></textarea>
                <i class="fa fa-check text-primary" style="cursor: pointer" @click="update('w')"></i>
            </div>
            <div class="col-md-6">
                <textarea rows="10" class="form-control" placeholder="Enter Ad Code Blogger" v-model="blogger"></textarea>
                <i class="fa fa-check text-primary" style="cursor: pointer" @click="update('b')"></i>
            </div>
        </div>    
    </section>
</template>

<script>
import axios from 'axios'
export default {
 props: [ 'wp', 'blg', 'domain', 'user', 'website', 'csrf', 'rote'],
 data() {
     return {
         'wordpress': this.wp,
         'blogger': this.blg,
     }
 },
 methods: {
     update(t){

         let formData = new FormData()
         
         formData.append('user_id', this.user)
         formData.append('domain_id', this.domain)
         if(t == 'w'){
             formData.append('ad_code', this.wordpress)
         }
         if(t == 'b'){
             formData.append('ad_code_footer', this.blogger)
         }
         formData.append('_token', this.csrf)
         
         axios
            .post(this.rote, formData )
            .then(res => {
                    alert('AdCode Updated.')
                })
            .catch(err => {
                    alert(err)
                })
     },
 },
}
</script>
