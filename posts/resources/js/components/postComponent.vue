<template>
    <div class="container container-task">
     <h2>Publicar Post</h2>
        <div class="row">
           
            <div class="col-md-6">
                <div class="form-group"><!-- Formulario para la creación o modificación de nuestras tareas-->
                    <label>Nombre</label>
                    <input v-model="author" type="text" class="form-control">

                    <label>Descripción</label>
                    <input v-model="title" type="text" class="form-control">

                    <label>Contenido</label>
                    <input v-model="content" type="text" class="form-control">
                </div>
                <div class="container-buttons">
                    <!-- Botón que añade los datos del formulario, solo se muestra si la variable update es igual a 0-->
                    <button v-if="update == 0" @click="savePosts()" class="btn btn-success">Añadir</button>
                    <!-- Botón que modifica la tarea que anteriormente hemos seleccionado, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="updatePosts()" class="btn btn-warning">Actualizar</button>
                    <!-- Botón que limpia el formulario y inicializa la variable a 0, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="clearFields()" class="btn">Atrás</button>
                </div>
            </div>
       
         <div class="col-md-6"> 
                <table class="table text-center"><!--Creamos una tabla que mostrará todas las tareas-->
                        <thead>
                            <tr>
                                <th scope="col">Author</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Contenido</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in arrayPosts" :key="post.id"> 
                                <td v-text="post.name"></td>
                                <td v-text="post.description"></td>
                                <td v-text="post.content"></td>
                                <td>
                                    <button class="btn" @click="loadFieldsUpdate(post)">Modificar</button>
                                    <!--Botón que borra la tarea que seleccionemos-->
                                    <button class="btn" @click="deletePost(post)">Borrar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
             </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                author:"",
                title:"", 
                content:"",
                update:0, 
                arrayPosts:[]
            }
        },
        methods:{
            getPosts(){
                let me =this;
                let url = '/posts' //Ruta que hemos creado para que nos devuelva todas las tareas
                axios.get(url).then(function (response) {
                    //creamos un array y guardamos el contenido que nos devuelve el response
                    me.arrayPosts = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            savePosts(){
                let me =this;
                let url = '/posts/guardar' //Ruta que hemos creado para enviar una tarea y guardarla
                axios.post(url,{ //estas variables son las que enviaremos para que crear la tarea
                    'author':this.author,
                    'title':this.title,
                    'content':this.content,
                }).then(function (response) {
                    me.getPosts();//llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
                    me.clearFields();//Limpiamos los campos e inicializamos la variable update a 0
                })
                .catch(function (error) {
                    console.log(error);
                });   
                
            },
            updateTasks(){/*Esta funcion, es igual que la anterior, solo que tambien envia la variable update que contiene el id de la
                tarea que queremos modificar*/
                let me = this;
                axios.put('/tareas/actualizar',{
                    'id':this.update,
                    'author':this.author,
                    'title':this.title,
                    'content':this.content,
                }).then(function (response) {
                   me.getPosts();
                   me.clearFields();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(data){ //Esta función rellena los campos y la variable update, con la tarea que queremos modificar
                this.update = data.id
                let me =this;
                let url = '/posts/buscar?id='+this.update;
                axios.get(url).then(function (response) {
                    me.author= response.data.author;
                    me.title= response.data.title;
                    me.content= response.data.content;
                    
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                }); 
            },
            deletePost(data){
                let me =this;
                let post_id = data.id
                if (confirm('¿Seguro que deseas borrar este post?')) {
                    axios.delete('/posts/borrar/'+post_id
                    ).then(function (response) {
                        me.getPosts();
                    })
                    .catch(function (error) {
                        console.log(error);
                    }); 
                }
            },
            clearFields(){/*Limpia los campos e inicializa la variable update a 0*/
                this.author = "";
                this.title = "";
                this.content = "";
                this.update = 0;
            }
        },
        mounted() {
           this.getPosts();
        }
    }
</script>