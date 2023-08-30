<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>EDIT JADWAL HARIAN</h4>
                        <hr />
                        <form @submit.prevent="update">
                            <div class="form-group mb-13">
                                <label for="content" class="form-label">Status Kelas</label>
                                <select class="form-control" v-model="jadwalHarian.status">
                                    <option selected disabled value="">Pilih Status</option>
                                    <option value="1">Tidak Libur</option>
                                    <option value="2">Libur</option>
                                </select>
                                <!-- validation -->
                                <div v-if="validation.status" class="mt-2 alert alert-danger">
                                    {{ validation.status[0] }}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { reactive, ref, onMounted} from "vue";
    import { useRouter, useRoute } from "vue-router";
    import axios from "axios";
    import { useToast } from "vue-toastification";
    export default {
        setup() {
            //state user
            const jadwalHarian = reactive({
                status: "",
            });
            //state validation
            const validation = ref([]);
            //vue router
            const router = useRouter(); 
            const route = useRoute();
            const id = route.params.id
            const token = localStorage.getItem('token')


            onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            //get API from Laravel Backend
            axios
                .get("http://localhost:8000/api/jadwalHarian/" + id,)
                .then(response => {
                    //assign state posts with response data
                    jadwalHarian.status = response.data.data.status
                }).catch(error => {
                    console.log(error.response.data)
                })
            })

            function update() {
                let status = jadwalHarian.status;
                let toast = useToast();
                axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
                axios
                    .put("http://localhost:8000/api/jadwalHarian/" + id, {
                        status : status
                    })
                    .then(() => {
                        toast.success("Berhasil Edit Data !",{
                            timeout: 2000
                        })
                        //redirect ke post index
                        router.push({
                            name: "mo.jadwal_harian.index",
                        });
                    })
                    .catch((error) => {
                        //assign state validation with error
                        validation.value = error.response.data
                    });
            }
            //return
            return {
                jadwalHarian,
                validation,
                router,
                update,
            };
        },
    };

</script>
<style>

</style>