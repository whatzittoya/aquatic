<template>
    <div>

        <div class="row">

            <div class="col-md-12">
                <v-card-title>
                    Peserta
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-data-table :headers="headers" :items="participants" class="elevation-1" :search="search">
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details>
                            </v-text-field>

                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Peserta</v-btn>
                                </template>
                                <v-card>
                                    <v-form @keyup.native.enter="save">
                                        <v-card-title>
                                            <span class="headline">{{ formTitle }}</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                             
                                                 <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.event" :items="events" item-text="name"
                                                            item-value="id" label="Kategori" ></v-select>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.race" :items="races" item-text="name"
                                                            item-value="id" label="Lomba" ></v-select>
                                                    </v-col>
                                                     <v-col cols="12" sm="12" md="6">
                                                          <v-select v-model="form.club" :items="clubs" item-text="name"
                                                            item-value="id" label="Klub" ></v-select>
                                                    </v-col>
                                                     <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.member" :items="members" item-text="name"
                                                            item-value="id" label="Peserta" ></v-select>
                                                    </v-col>
                                                   
                                                     <v-col cols="12" sm="12" md="6">
                                                        <v-text-field ref="date_birth" v-model="form.date_birth" label="tanggal lahir"
                                                            :rules="[rules.required]"></v-text-field>
                                                    </v-col>
                                                      <v-col cols="12" sm="12" md="6">
                                                        <v-text-field ref="age" v-model="form.age" label="Umur"
                                                            :rules="[rules.required]"></v-text-field>
                                                    </v-col>
                                                      <v-col cols="12" sm="12" md="6">
                                                        <v-text-field ref="best_time" v-model="form.best_time" label="Best Time"
                                                            :rules="[rules.required]"></v-text-field>
                                                    </v-col>
                                                       <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.style" :items="styles" item-text="style"
                                                            item-value="id" label="Gaya" ></v-select>
                                                    </v-col>
                                                       <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.distance" :items="distances" item-text="distance"
                                                            item-value="id" label="Jarak" ></v-select>
                                                    </v-col>
                                                       <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.name" :items="names" item-text="name"
                                                            item-value="id" label="Nama Lomba" ></v-select>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>

                                            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>

                                            <v-btn color="blue darken-1" text @click="save">Save</v-btn>

                                        </v-card-actions>
                                    </v-form>
                                </v-card>
                            </v-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:item.action="{ item }">
                        <v-icon small class="mr-2" @click="editData(item)">
                            edit
                        </v-icon>
                        <v-icon small @click="deleteData(item.id)">
                            delete
                        </v-icon>


                        <!-- <a :href="'/admin/members/'+member.id" target="_blank" class="btn btn-primary">Lampiran</a> -->
                    </template>
                </v-data-table>

            </div>
        </div>
    </div>
</template>

<!-- script js -->
<script>
export default {
  computed: {
    formTitle() {
      return this.edit === false ? "New Item" : "Edit Item";
    },
    formtest() {
      return {
        name: this.form.name,
        age: this.form.age,
        born_date: this.form.born_date,
        best_time: this.form.best_time,
        distance: this.form.distance,
        style: this.form.style
      };
    }
  },
  data() {
    return {
      // variable array yang akan menampung hasil fetch dari api
      rules: {
        required: value => !!value || "Required."
      },
      date: new Date().toISOString().substr(0, 10),

      headers: [
        { text: "Nama Peserta", value: "member.name" },
        { text: "Club", value: "member.club.name" },
        { text: "Event", value: "race.event.name" },
        { text: "Lomba", value: "race.name" },
        { text: "Best Time", value: "best_time" },
        { text: "Hasil", value: "result" },

        { text: "Aksi", value: "action", sortable: false }
      ],

      participants: [],
      members: [],
      events: [],
      races: [],
      clubs: [],

      edit: false,
      showModal: false,
      form: {},
      defaultForm: {},
      search: "",
      dialog: false,
      formHasErrors: false
    };
  },
  created() {
    this.loadData();
  },

  methods: {
    loadData() {
      // fetch data dari api menggunakan axios
      axios.get("/api/participants").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.participants = response.data;
        // console.log(response.data);
      });
      this.defaultForm = {
        name: "",
        date_birth: "",
        age: "",
        best_time: "",
        style: "",
        distance: ""
      };
      axios.get("/api/clubs").then(response => {
        this.clubs = response.data;
        this.defaultForm.club = this.clubs[0].id;
      });
      axios.get("/api/members").then(response => {
        this.members = response.data;
        this.defaultForm.member = this.members[0].id;
      });
      axios.get("/api/events").then(response => {
        this.events = response.data;
        this.defaultForm.events = this.events[0].id;
      });
      axios.get("/api/races").then(response => {
        this.races = response.data;
        this.defaultForm.races = this.events[0].id;
      });

      this.form = this.defaultForm;
    },
    deleteData(id) {
      // delete data
      if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        axios.delete("/api/participants/" + id).then(response => {
          this.loadData();
        });
      }
    },
    editData(item) {
      // delete data
      this.form = Object.assign({}, item);
      this.edit = true;
      this.dialog = true;
    },
    createData() {
      // delete data
      this.edit = false;
      this.dialog = true;
    },
    save() {
      this.formHasErrors = false;

      Object.keys(this.formtest).forEach(f => {
        if (!this.formtest[f]) this.formHasErrors = true;
        console.log(this.formtest[f]);
        this.$refs[f].validate(true);
      });
      if (!this.formHasErrors && this.file_error_messages == null) {
        // post data ke api menggunakan axios
        if (this.edit && this.form.id > 0) {
          axios
            .post("/api/participants/" + this.form.id, {
              data: this.form,
              _method: "patch"
            })
            .then(response => {
              // push router ke read data
              this.loadData();
              this.close();
            });
        } else {
          axios.post("/api/participants", this.form).then(response => {
            // push router ke read data
            this.loadData();
            this.close();
          });
        }
      }
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.form = Object.assign({}, this.defaultForm);
        this.edit = false;
        Object.keys(this.formtest).forEach(f => {
          if (!this.formtest[f]) this.formHasErrors = true;
          this.$refs[f].reset();
        });
      }, 300);
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    }
  }
};
</script>