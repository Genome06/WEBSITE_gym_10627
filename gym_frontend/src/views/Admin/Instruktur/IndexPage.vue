<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST INSTRUKTUR</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <router-link :to="{ name: 'admin.instruktur.create' }" class="btn btn-md btn-success mb-4">TAMBAH
                            Instruktur</router-link>
                            <div>
                                <button @click.prevent="search()" class="btn btn-sm btn-primary mr-1">Cari</button>
                                <input v-model="searchQuery" type="text" form="form-control" placeholder="Cari...."/>
                            </div>   
                        </div>
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">Nama Instruktur</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Telepon</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(instruktur, id) in instruktur" :key="id" class="text-center">
                                    <td>{{ instruktur.nama }}</td>
                                    <td>{{ instruktur.username }}</td>
                                    <td>{{ instruktur.no_hp }}</td>
                                    <td>{{ instruktur.alamat }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'admin.instruktur.edit', params: { id: instruktur.id } }" 
                                        class="btn btn-sm btn-primary mr-1">EDIT</router-link>
                                        &nbsp;
                                        <button @click.prevent="instrukturDelete(instruktur.id)" class="btn btn-sm btn-danger ml-1">DELETE</button>
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
        let instruktur = ref([])
        let searchQuery = ref([])
        const token = localStorage.getItem('token')
        let toast = useToast();
        onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/instruktur')
            .then(response => {
                instruktur.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            
        })

        function search(){
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/instrukturSearch', {
                params: {
                    query : searchQuery.value
                }
            }).then(response => {
                instruktur.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        //method delete
        function instrukturDelete(id) {
            axios.delete(`http://localhost:8000/api/instruktur/${id}`)
            .then(() => {
                        toast.error("Berhasil Hapus Data !",{
                            timeout: 2000
                        })
                    instruktur.value.splice(instruktur.value.indexOf(id), 1);
            }).catch(error => {
                console.log(error.response.data)
            })
        }
        return {
            instruktur,
            searchQuery,
            instrukturDelete,
            search
        }
    }
}
</script>
<style>
</style>