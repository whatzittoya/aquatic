<template>
    <div>

        <div class="row">

            <div class="col-md-12">
                <v-card-title>
                    Rule
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-data-table :headers="headers" :items="rules" class="elevation-1" :search="search">
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details>
                            </v-text-field>

                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Rule</v-btn>
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
                                                        <v-text-field ref="name" v-model="form.name" label="Nama"
                                                            :rules="[rules_form.required]"></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field ref="min_age" v-model="form.min_age" label="Umur Min" type="number"
                                                            :rules="[rules_form.zero,rules_form.min(form.max_age,form.min_age)]" class="invalid"></v-text-field>
                                                            
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field ref="max_age" v-model="form.max_age" label="Umur max" type="number"
                                                            :rules="[rules_form.zero,rules_form.max(form.min_age,form.max_age)]"></v-text-field>
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
          <loading :active.sync="isLoading" 
        :can-cancel="false" 
   
        :is-full-page="fullPage"></loading>
    </div>
</template>

<!-- script js -->
<script>
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  components: {
    Loading
  },
  computed: {
    formTitle() {
      return this.edit === false ? "New Item" : "Edit Item";
    },
    formtest() {
      return {
        name: this.form.name,
        min_age: this.form.min_age,
        max_age: this.form.max_age
      };
    }
  },
  data() {
    return {
      isLoading: false,
      fullPage: true,
      rules_form: {
        required: value => !!value || "Required.",
        zero: value => value >= 0 || "Umur tidak boleh kurang dari 0",

        min(max, v) {
          return (
            parseInt(v) <= parseInt(max) ||
            `Umur Min tidak boleh lebih dari  Umur Max ${max}`
          );
        },
        max(min, v) {
          return (
            parseInt(v) >= parseInt(min) ||
            `Umur Min tidak boleh Kurang dari  Umur Min ${min}`
          );
        }
      },
      // rules_min: [
      //   v => !!v || "Required",
      //   v => v >= form.max_age || "Umur Min tidak boleh lebih dari  Umur Max",
      //   v => v < 0 || "Umur Min tidak boleh kurang dari 0"
      // ],
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      menu_start: false,
      menu_end: false,
      headers: [
        { text: "Nama", value: "name" },
        { text: "Umur Min", value: "min_age" },
        { text: "Umur Max", value: "max_age" },

        { text: "Aksi", value: "action", sortable: false }
      ],

      rules: [],
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
      axios.get("/api/rules").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.rules = response.data;
        // console.log(response.data);
      });
      this.defaultForm = {
        name: "",
        min_age: 0,
        max_age: 1
      };
      this.form = this.defaultForm;
    },
    deleteData(id) {
      // delete data
      if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        axios.delete("/api/rules/" + id).then(response => {
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

        this.$refs[f].validate(true);
      });
      if (!this.formHasErrors && this.file_error_messages == null) {
        // post data ke api menggunakan axios
        if (this.edit && this.form.id > 0) {
          this.isLoading = true;
          axios
            .post("/api/rules/" + this.form.id, {
              data: this.form,
              _method: "patch"
            })
            .then(response => {
              // push router ke read data
              this.loadData();
              this.isLoading = false;
              this.close();
            });
        } else {
          this.isLoading = true;
          axios.post("/api/rules", this.form).then(response => {
            // push router ke read data
            this.loadData();
            this.isLoading = false;
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