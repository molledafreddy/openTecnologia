<template>
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3>Empleados</h3>
                    </div>
                    <div class="pull-right">
                         <button class="btn btn-primary" @click="showModal = true"> <i class="fa fa-plus-square-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Ciudad</th>
                                </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(employee, index) in employees">
                                <td>{{employee.name}}</td>
                                <td>{{ employee.cities.length > 0 ? employee.cities[0].description : '' }}</td>
                                <td v-text="checkstatus(user)"></td>
                                <td>
                                    <button class="btn btn-primary btn-xs" @click="edit(index)">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn btn-danger btn-xs" @click="destroy(user.id)">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <modal v-if="showModal" @close="showModal = false" @save="save">
                        <h3 slot="header">Crear empleado</h3>
                        <div slot="body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" v-model="draft.name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Ciudades</label>
                                    <select class="form-control" v-model="draft.city_id">
                                        <option disabled value="">Seleccione una ciudad</option>
                                        <option v-for="(city, index) in cities" :value="city.id" >{{city.decription}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>    
                    </modal> 
                </div>
            </div>    
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                editing: false, // editar un empleado
                showModal: false, // crear un empleado
                draft: {
                    cities: [],
                },
                currentIndex: null,
                currentId: null,
                employees: [],
                cities: [],
                file: null, // variable guarda el archivo
                target: '',
                current: '',
                ready: false,
                last: '',
            }
        },
        mounted() {
            this.getEmployes(1);
        },
        methods:{
            getEmploye(page){
                var self = this;
                axios.get('/api/v1/employee?page=' + page)
                    .then(response => {
                        console.log(response);
                        self.employees = response.data.employees.data;
                        self.cities = response.data.cities;
                        self.current = response.data.employees.current_page;
                        self.last = response.data.employees.last_page;
                        self.ready = response.data.employees.last_page > 1;
                        this.target = '';
                    })
                    .catch(error => {
                         console.log(error);
                    })
            },
            save(){
                if (this.editing) {
                    this.update();
                }
                else{
                    this.store();
                }
                this.editing = false;
                this.showModal = false;
            },
            
            // end cargado el archivo de empleados
            store(){
                var self = this;
                axios.post('/api/v1/employee', this.draft)
                    .then(response => {                        
                        self.getEmployees(1);
                        self.draft = {};                        
                        alert(response.data.message);
                    })
                    .catch(error => {
                        console.log(error);
                    })                
            },
            update(){
                var self = this;
                axios.put('/api/v1/employee/' + this.currentId, this.draft)
                    .then( function(response){                        
                        self.employees[self.currentIndex] = self.draft;
                        self.draft = {};  
                        self.getEmployees();
                    })
                    .catch(error => {
                        alert(error.data.message);
                    })                  
            },
            edit(index){
                this.draft = Object.assign({}, this.employees[index]);
                this.draft.bank_id = this.employees[index].cities[0].id; 
                this.currentIndex = index;
                this.currentId = this.employees[index].id;
                this.showModal = true;
                this.editing = true;
            },

            destroy(id){
               var self = this;
                axios.get('/api/v1/employee/delete?id=' + id)
                    .then(function(response) {
                        console.log(response);
                        alert(response.data.message);
                        self.getEmployees();
                    })
                    .catch(error => {
                        alert(error.data.message);
                    }) 
            },
            
        },
    }
</script>
