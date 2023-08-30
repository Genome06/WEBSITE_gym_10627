<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST PEGAWAI</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <router-link :to="{ name: '' }" class="btn btn-md btn-success mb-4">TAMBAH
                            Pegawai</router-link>
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">Nama Pegawai</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Telepon</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(pegawai, id) in pegawai" :key="id" class="text-center">
                                    <td>{{ pegawai.nama }}</td>
                                    <td>{{ pegawai.username }}</td>
                                    <td>{{ pegawai.jabatan }}</td>
                                    <td>{{ pegawai.no_hp }}</td>
                                    <td>{{ pegawai.alamat }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: '', params: { id: pegawai.id } }" 
                                        class="btn btn-sm btn-primary mr-1">EDIT</router-link>
                                        &nbsp;
                                        <button @click.prevent="pegawaiDelete(pegawai.id)" class="btn btn-sm btn-danger ml-1">DELETE</button>
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
import { useToast } from "vue-toastification";
export default {
    setup() {
        let pegawai = ref([])
        const token = localStorage.getItem('token')
        
        let toast = useToast();
        onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/pegawai')
            .then(response => {
                pegawai.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            
        })
        //method delete
        function pegawaiDelete(id) {
            axios.delete(`http://localhost:8000/api/pegawai/${id}`)
            .then(() => {
                        toast.error("Berhasil Hapus Data !",{
                            timeout: 2000
                        })
                        pegawai.value.splice(pegawai.value.indexOf(id), 1);
            }).catch(error => {
                console.log(error.response.data)
            })
        }
        return {
            pegawai,
            pegawaiDelete
        }
    }
}
</script>
<style>
</style>