<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            <button v-on:click="create_siswa()" class="btn btn-primary btn-xs pull-right">Tambah Siswa</button>
            Data Siswa
          </div>
          <div class="panel-body">
            <table class="table table-bordered table-striped table-responsive" v-if="data.length > 0">
              <thead>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                <tr v-for="(value, index) in data">
                  <td>{{ index + 1 }}</td>
                  <td>{{ value.nis }}</td>
                  <td>{{ value.nama }}</td>
                  <td>{{ value.kelas }}</td>
                  <td>
                    <button type="button" class="btn btn-success btn-xs" v-on:click="edit_siswa(index)">Edit</button>
                    <button type="button" class="btn btn-danger btn-xs" v-on:click="delete_siswa(index)">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="add_siswa" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Tambah Siswa Baru</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <ul>
                <li v-for="error in errors">{{ error }}</li>
              </ul>
            </div>
            <div class="form-group">
              <label for="nis">NIS</label>
              <input type="text" class="form-control" id="nis" placeholder="NIS" v-model="siswa.nis">
            </div>
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="form-control" id="nama" placeholder="Nama" v-model="siswa.nama">
            </div>
            <div class="form-group">
              <label for="kelas">Kelas</label>
              <input type="text" class="form-control" id="kelas" placeholder="Kelas" v-model="siswa.kelas">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" v-on:click="store_siswa()">Tambah</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="edit_siswa" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Edit Siswa</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <ul>
                <li v-for="error in errors">{{ error }}</li>
              </ul>
            </div>
            <div class="form-group">
              <label for="nis">NIS</label>
              <input type="text" class="form-control" id="nis" placeholder="NIS" v-model="update.nis">
            </div>
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="form-control" id="nama" placeholder="Nama" v-model="update.nama">
            </div>
            <div class="form-group">
              <label for="kelas">Kelas</label>
              <input type="text" class="form-control" id="kelas" placeholder="Kelas" v-model="update.kelas">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" v-on:click="update_siswa()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      siswa: {
        nis: '',
        nama: '',
        kelas: ''
      },
      errors: [],
      data: [],
      update: [],
    }
  },
  mounted() {
    this.list_siswa();
  },
  methods: {
    create_siswa() {
      this.errors = [];
      $('#add_siswa').modal('show');
    },

    store_siswa() {
      axios.post('/siswa/create', {
        nis: this.siswa.nis,
        nama: this.siswa.nama,
        kelas: this.siswa.kelas
      }).then(response => {
        this.reset();
        this.list_siswa();
        $('#add_siswa').modal('hide');
        alert(response.data.message);
      }).catch(error => {
        this.errors = [];
        if (error.response.data.errors.nis) {
          this.errors.push(error.response.data.errors.nis[0]);
        }

        if (error.response.data.errors.nama) {
          this.errors.push(error.response.data.errors.nama[0]);
        }

        if (error.response.data.errors.kelas) {
          this.errors.push(error.response.data.errors.kelas[0]);
        }
      });
    },

    reset() {
      this.siswa.nis = '';
      this.siswa.nama = '';
      this.siswa.kelas = '';
    },

    list_siswa() {
      axios.get('/siswa').then(response => {
        this.data = response.data.siswa;
      });
    },

    edit_siswa(index) {
      this.errors = [];
      $("#edit_siswa").modal("show");
      this.update = this.data[index];
    },

    update_siswa() {
      axios.post('/siswa/update', {
        id: this.update.id,
        nis: this.update.nis,
        nama: this.update.nama,
        kelas: this.update.kelas
      }).then(response => {
        this.reset();
        this.list_siswa();
        $("#edit_siswa").modal("hide");
        alert(response.data.message);
      }).catch(error => {
        this.errors = [];
        if (error.response.data.errors.nis) {
          this.errors.push(error.response.data.errors.nis[0]);
        }

        if (error.response.data.errors.nama) {
          this.errors.push(error.response.data.errors.nama[0]);
        }

        if (error.response.data.errors.kelas) {
          this.errors.push(error.response.data.errors.kelas[0]);
        }
      });
    },

    delete_siswa(index) {
      let conf = confirm("Apakah anda yakin akan menghapus data " + this.data[index].nama + " ?");
      if (conf === true) {
        axios.get('/siswa/' + this.data[index].id + '/delete').then(response => {
          this.reset();
          this.list_siswa();
          alert(response.data.message);
        }).catch(error => {

        });
      }
    }
  }
}
</script>
