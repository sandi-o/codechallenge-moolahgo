<template>
<v-container fluid>
    <v-dialog v-model="dialog" max-width="700" persistent>    
    <v-form ref="form" v-model="valid" @submit.prevent="submit" lazy-validation>
    <v-card>
        <v-card-title>Check Referral Code</v-card-title>
        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <v-text-field
                        v-model="referral_code"
                        placeholder="e.g. REFCDE"
                        label="*Referral Code"
                        :rules="rules"
                        required
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <div class="overline">{{this.code_owner}}</div>
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions>
            <v-btn
                color="secondary"
                text
                :disabled="disabled"
                @click="clearForm"
            >
                Clear
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
                :disabled="!valid"
                color="success"
                raised
                :loading="loading"                
                @click="request"
            >
                Submit
            </v-btn>
        </v-card-actions>
    </v-card>
    </v-form>
    </v-dialog>
</v-container>
</template>

<script>
export default {
    data: () => ({        
        dialog: true,
        disabled: false,
        loading: false,
        referral_code: '',
        code_owner: '',
        rules: [
            v => !!v || 'Referral Code is Required.',
            v => v && v.length == 6 || 'Referral Code must be 6 characters long.',
            v => v && /^[A-Z0-9]+$/.test(v) || 'Referral Code letters must be UPPERCASE and letters and numbers ONLY.'
        ],
        valid: true
    }),
    methods: {
        clearForm() {
            this.referral_code = ''
            this.code_owner = ''
            this.valid = true
        },
        request() {
            if(this.$refs.form.validate()) {                
              this.send().then(result => {
                  this.code_owner = "The owner of the referral code is: "+result.referral_code
              }).catch(error => { 
                  this.code_owner = error.response.data.referral_code[0]
              })
            }
        },
        send() {
            return new Promise((resolve,reject) =>{
                this.$http.post('http://localhost:8000/process',{'referral_code':this.referral_code})
                .then(resp => {
                    resolve(resp.data)
                }).catch(err => {                    
                    reject(err)
                    throw err
                });
            });
        }
    }
}
</script>

<style>

</style>