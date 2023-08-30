<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST PROMO</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <router-link :to="{ name: '' }" class="btn btn-md btn-success mb-4">TAMBAH
                            PROMO</router-link>
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">NAMA Promo</th>
                                    <th scope="col">Potongan Promo</th>
                                    <th scope="col">Tenggang Waktu Aktif</th>
                                    <th scope="col">Status Promo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(promo, id) in promo" :key="id" class="text-center">
                                    <td>{{ promo.nama }}</td>
                                    <td>{{ promo.potongan_promo }}</td>
                                    <td>{{ formatDate(promo.masa_aktif, "fullDate") }}</td>
                                    <td v-if="promo.status_aktif=='1'">Tersedia</td>
                                    <td v-else>Tidak Tersedia</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: '', params: { id: promo.id } }" 
                                        class="btn btn-sm btn-primary mr-1">EDIT</router-link>
                                        &nbsp;
                                        <button @click.prevent="promoDelete(promo.id)" class="btn btn-sm btn-danger ml-1">DELETE</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { onMounted, ref } from 'vue'
import moment from "moment"
import { useToast } from "vue-toastification";
export default {
    setup() {
        let promo = ref([])
        const token = localStorage.getItem('token')
        
        let toast = useToast();
        onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/promo')
            .then(response => {
                promo.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            
        })
        //method delete
        function promoDelete(id) {
            axios.delete(`http://localhost:8000/api/promo/${id}`)
            .then(() => {
                        toast.error("Berhasil Hapus Data !",{
                            timeout: 2000
                        })
                        promo.value.splice(promo.value.indexOf(id), 1);
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        
        function formatDate(date, dateType){
                const date1 = new Date(date);
                if (dateType === "fullDate") {
                     return moment(date1).format("D MMMM YYYY");
                }
        }
        return {
            promo,
            promoDelete,
            formatDate
        }
    }
}
</script>
<style>
</style>