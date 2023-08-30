<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST AKTIVASI TAHUNAN MEMBER</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <router-link :to="{ name: 'kasir.aktivasiTahunan.create' }" class="btn btn-md btn-success mb-4">TAMBAH 
                            TRANSAKSI AKTIVASI</router-link>      
                        </div>       
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">Nama Member</th>
                                    <th scope="col">Nama Kasir</th>
                                    <th scope="col">Tanggal Aktivasi</th>
                                    <th scope="col">Biaya Aktivasi</th>
                                    <th scope="col">Masa Aktif</th>
                                    <th scope="col">No Transaksi</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(aktivasi, id) in aktivasi" :key="id" class="text-center">
                                    <td>{{ aktivasi.member.nama }}</td>
                                    <td>{{ aktivasi.pegawai.nama }}</td>
                                    <td>{{ aktivasi.waktu }}</td>
                                    <td>{{ aktivasi.biaya_aktivasi }}</td>
                                    <td>{{ aktivasi.masa_aktif }}</td>
                                    <td>{{ aktivasi.no_aktivasi }}</td>
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
        let aktivasi = ref([])
        const token = localStorage.getItem('token')
        //let searchQuery = ref([])

        //let toast = useToast();
        onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/aktivasiTahunan')
            .then(response => {
                aktivasi.value = response.data.data
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
            aktivasi,
            //searchQuery,
            //search,
            //memberDelete
        }
    }
}
</script>
<style>
</style>