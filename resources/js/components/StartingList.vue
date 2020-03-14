<template>
    <div>

        <div class="row">

            <div class="col-md-12">
                <v-card-title>
                    Starting List
                    <v-spacer></v-spacer>
                </v-card-title>
                   <v-select v-model="event" :items="events"
                                                            item-text="name" item-value="id" label="Pilih Event" return-object=""
                                                      ></v-select>
                <v-data-table :headers="headers" :items="starting_lists" class="elevation-1" :search="search">
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details>
                            </v-text-field>
 <v-spacer></v-spacer>
                        <v-menu offset-y v-if="role=='admin'">
                            <template v-slot:activator="{ on }">
                              <v-btn color="success" dark v-on="on" >
                                Export
                              </v-btn>
                            </template>
                            <v-list>
                              <v-list-item :href="'/admin/startinglist/export_excel_slist/'+id" target="_blank">
                                <v-list-item-title >Export Starting List</v-list-item-title>
                              </v-list-item>
                               <v-list-item :href="'/admin/startinglist/export_excel_match/'+id" target="_blank">
                                <v-list-item-title>Export Pertandingan</v-list-item-title>
                              </v-list-item>
                            </v-list>
                          </v-menu>
                    
                        </v-toolbar>
                    </template>
                <template v-slot:item.number="{ item }">
{{starting_lists.map(function(x) {return x.id; }).indexOf(item.id)+1 }}
                </template>
                   <template v-slot:item.year="{ item }">
{{getYear(item.member.born_date)}}
                </template>
                     <template v-slot:item.best_time="{ item }">
{{timeFormat(item.old_best_time)}}
                </template>
                </v-data-table>

            </div>
        </div>
     
    </div>
</template>

<!-- script js -->
<script>
export default {
  data() {
    return {
      i: 0,
      search: "",
      events: [],
      event: "",
      id: "",
      role: "",
      headers: [
        { text: "No", value: "number" },
        { text: "Nomor Lomba", value: "race.race_number" },
        { text: "Nama Peserta", value: "member.name" },
        { text: "Nama Lomba", value: "race.pure_races.name" },
        { text: "Tahun Lahir", value: "year" },
        { text: "Klub", value: "member.clubs.name" },
        { text: "Kota", value: "member.clubs.city" },
        { text: "Provinsi", value: "member.clubs.province" },
        { text: "Best Time", value: "best_time" }
      ],

      starting_lists: []
    };
  },
  created() {
    this.loadData();
  },

  methods: {
    loadData() {
      axios.get("/api/role").then(response => {
        // mengirim data hasil fetch ke varibale array persons
        this.role = response.data.name;
      });
      axios.get("/api/events").then(response => {
        this.events = response.data;
      });

      if (this.id > 0) {
        // fetch data dari api menggunakan axios
        axios.get("/api/startinglist/" + this.id).then(response => {
          // mengirim data hasil fetch ke varibale array persons
          this.starting_lists = response.data;
        });
      }
    },
    getYear(val) {
      var d = new Date(val);
      return d.getFullYear();
    },
    timeFormat(milisecond) {
      let hour = 0;
      let minute = 0;
      let second = 0;
      let mili = 0;

      hour = Math.floor(milisecond / 3600000);

      if (hour.toString.length < 2) {
        hour = ("0" + hour).slice(-2);
      }
      milisecond = milisecond - hour * 3600000;

      minute = Math.floor(milisecond / 60000);
      minute = ("0" + minute).slice(-2);
      milisecond = milisecond - minute * 60000;
      second = Math.floor(milisecond / 1000);
      second = ("0" + second).slice(-2);
      milisecond = milisecond - second * 1000;
      mili = milisecond;
      mili = ("00" + mili).slice(-3);

      return hour + ":" + minute + ":" + second + "." + mili;
    }
  },
  watch: {
    event(val) {
      if (val.id > 0) {
        this.id = val.id;

        this.loadData();
      }
    }
  }
};
</script>