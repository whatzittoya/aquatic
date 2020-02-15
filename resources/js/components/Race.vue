<template>
    <div>

        <div class="row">

            <div class="col-md-12">
                <v-card-title>
                    Lomba
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-data-table :headers="headers" :items="races" class="elevation-1" :search="search">
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details>
                            </v-text-field>

                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Lomba</v-btn>
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
                                                        <v-text-field ref="race_number" v-model="form.race_number"
                                                            label="Nomor" :rules="[races_form.required]" :error-messages="formerrors.race_number">
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="ruleselected" :items="rules_race" item-text="name"
                                                            item-value="id" label="Kategori" return-object></v-select>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-select v-model="form.gender" :items="genders" label="Jenis Kelamin"></v-select>
                                                    </v-col>
                                                     <v-col cols="12" sm="12" md="6">
                                                        <v-text-field ref="style" v-model="form.style"
                                                            label="Gaya" :rules="[races_form.required]" >
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field ref="distance" v-model="form.distance"
                                                            label="Jarak" :rules="[races_form.required]">
                                                        </v-text-field>
                                                    </v-col>
                                                     <v-col cols="12" sm="12" md="12">
                                                        <v-text-field  v-model="textname"
                                                            label="Name" :error-messages="formerrors.name">
                                                        </v-text-field>
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
 <!-- <v-select v-model="a.currentItem" :items="items"></v-select> -->
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
    textname: {
      get() {
        if (!this.disablewatch) {
          const race_n =
            this.form.race_number === undefined
              ? ""
              : this.form.race_number + " - ";
          const dist =
            this.form.distance === undefined ? "" : this.form.distance + " - ";
          const style =
            this.form.style === undefined ? "" : this.form.style + " - ";

          return (
            race_n + dist + style + this.form.gender + " - " + this.ruletext
          );
        } else {
          this.disablewatch = true;
          return this.form.name;
        }
      },
      set(val) {
        this.disablewatch = true;
        this.form.name = val;
      }
    },
    formtest() {
      return {
        race_number: this.form.race_number,
        style: this.form.style,
        distance: this.form.distance
      };
    }
  },
  data() {
    return {
      ruleselected: {},

      races_form: {
        required: value => !!value || "Required."
      },
      date: new Date().toISOString().substr(0, 10),

      headers: [
        { text: "Nama", value: "name" },
        { text: "Kategori", value: "rule.name" },
        { text: "Nomor", value: "race_number" },
        { text: "Jenis Kelamin", value: "gender" },
        { text: "Gaya", value: "style" },
        { text: "Jarak", value: "distance" },
        { text: "Aksi", value: "action", sortable: false }
      ],
      races: [],
      genders: [{ text: "LAKI-LAKI" }, { text: "PEREMPUAN" }],
      races: [],
      rules_race: [],
      edit: false,

      showModal: false,
      form: {},
      defaultForm: {},
      formerrors: {
        race_number: "",
        name: ""
      },
      search: "",
      dialog: false,
      formHasErrors: false,

      ruletext: "",
      disablewatch: false
    };
  },
  created() {
    this.loadData();
  },

  methods: {
    loadData() {
      axios.get("/api/races").then(response => {
        this.races = response.data;
      });
      this.defaultForm = {
        name: "",
        race_number: "",
        gender: "Laki-laki",
        style: "",
        distance: ""
      };
      this.form = this.defaultForm;
      axios.get("/api/rules").then(response => {
        this.rules_race = response.data;
        this.ruleselected = this.rules_race[0];
      });
    },
    deleteData(id) {
      // delete data
      if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        axios.delete("/api/races/" + id).then(response => {
          this.loadData();
        });
      }
    },
    editData(item) {
      // delete data
      this.form = Object.assign({}, item);

      this.edit = true;
      this.dialog = true;
      this.disablewatch = true;
    },
    createData() {
      // delete data
      this.edit = false;
      this.dialog = true;
    },
    save() {
      this.formHasErrors = false;
      this.form.rule = this.ruleselected.id;

      this.form.name = this.textname;
      //   console.log(this.form);
      Object.keys(this.formtest).forEach(f => {
        if (!this.formtest[f]) this.formHasErrors = true;
        console.log(f);
        this.$refs[f].validate(true);
      });
      if (!this.formHasErrors && this.file_error_messages == null) {
        // post data ke api menggunakan axios
        if (this.edit && this.form.id > 0) {
          axios
            .post("/api/races/" + this.form.id, {
              data: this.form,
              _method: "patch"
            })

            .then(response => {
              // push router ke read data
              this.loadData();
              this.close();
            })
            .catch(errors => {
              this.formerrors.race_number =
                errors.response.data.errors.race_number;
              this.formerrors.name = errors.response.data.errors.name;
            });
        } else {
          axios
            .post("/api/races", this.form)
            .then(response => {
              // push router ke read data

              this.loadData();
              this.close();
            })
            .catch(errors => {
              this.formerrors.race_number =
                errors.response.data.errors.race_number;
              this.formerrors.name = errors.response.data.errors.name;
            });
        }
      }
    },
    close() {
      this.disablewatch = false;
      this.dialog = false;
      this.formerrors.name = "";
      this.formerrors.race_number = "";
      setTimeout(() => {
        this.form = this.defaultForm;
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
    },

    ruleselected(newVal) {
      this.ruletext = newVal.name;
    }
  }
};
</script>