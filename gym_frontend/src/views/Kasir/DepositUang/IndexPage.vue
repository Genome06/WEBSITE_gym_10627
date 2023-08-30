<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST DEPOSIT REGULER</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <router-link :to="{ name: 'kasir.depositUang.create' }" class="btn btn-md btn-success mb-4">TAMBAH 
                            TRANSAKSI DEPOSIT REGULER</router-link>      
                        </div>       
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">Nama Member</th>
                                    <th scope="col">Nama Kasir</th>
                                    <th scope="col">Tanggal Deposit</th>
                                    <th scope="col">Biaya Deposit</th>
                                    <th scope="col">Bonus Deposit</th>
                                    <th scope="col">Sisa Deposit</th>
                                    <th scope="col">No Transaksi</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(deposit, id) in deposit" :key="id" class="text-center">
                                    <td>{{ deposit.member.nama }}</td>
                                    <td>{{ deposit.pegawai.nama }}</td>
                                    <td>{{ deposit.waktu }}</td>
                                    <td>{{ deposit.biaya_deposit }}</td>
                                    <td>{{ deposit.promo.potongan_promo }}</td>
                                    <td>{{ deposit.member.sisa_deposit_uang }}</td>
                                    <td>{{ deposit.no_deposit }}</td>
                                    <td class="text-center">
                                        <button @click.prevent="" class="btn btn-info">CETAK</button>
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
//import { useToast } from "vue-toastification";
export default {
    setup() {
        let deposit = ref([])
        const token = localStorage.getItem('token')
        //let searchQuery = ref([])

        //let toast = useToast();
        onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/depositUang')
            .then(response => {
                deposit.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            
        })

       /* function search(){
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/membersSearch', {
                params: {
                    query : searchQuery.value
                }
            }).then(response => {
                member.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
        }*/
        //method delete
        /*function memberDelete(id) {
            axios.delete(`http://localhost:8000/api/members/${id}`)
            .then(() => {
                        toast.error("Berhasil Hapus Data !",{
                            timeout: 2000
                        })
                        member.value.splice(member.value.indexOf(id), 1);
            }).catch(error => {
                console.log(error.response.data)
            })
        }*/
        return {
            deposit,
            //searchQuery,
            //search,
            //memberDelete
        }
    }
}
</script>
<style>
</style>