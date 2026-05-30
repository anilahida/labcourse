<template>
  <div>

    <!-- Flash message -->
    <div v-if="flash" :style="flashStyle" style="border-radius:10px;padding:.7rem 1rem;margin-bottom:14px;font-size:.84rem;">
      {{ flash }}
    </div>

    <!-- Loading -->
    <div v-if="loading" style="text-align:center;padding:3rem 1rem;">
      <div class="spinner-border text-danger" role="status" style="width:2.5rem;height:2.5rem;"></div>
      <p style="color:#aaa;margin-top:.75rem;font-size:.85rem;">Duke ngarkuar librat...</p>
    </div>

    <template v-else>
      <!-- Filter bar -->
      <div class="filter-bar">
        <div class="srch-wrap-cli">
          <i class="bi bi-search"></i>
          <input type="text" v-model="search" class="srch-cli"
                 placeholder="Kërko titull ose autor..." autocomplete="off">
        </div>
        <span style="color:#aaa;font-size:.82rem;">{{ filteredBooks.length }} libra</span>
      </div>

      <!-- Category pills -->
      <div class="cat-pills">
        <a href="#" class="cat-pill" :class="{ active: activeCat === '' }"
           @click.prevent="activeCat = ''">Të gjitha</a>
        <a href="#" class="cat-pill" v-for="cat in categories" :key="cat.id"
           :class="{ active: activeCat == cat.id }"
           @click.prevent="activeCat = cat.id">
          {{ cat.emri }}
        </a>
      </div>

      <!-- Books grid -->
      <div class="books-grid">
        <div class="book-card" v-for="(book, i) in filteredBooks" :key="book.id">

          <a :href="appBase + '/books/' + book.id" style="text-decoration:none;">
            <div class="book-cover" :style="{ background: colors[i % colors.length][0] }">
              <i class="bi bi-book-half" :style="{ color: colors[i % colors.length][1], fontSize:'3rem' }"></i>
              <span class="book-stock" v-if="book.sasia > 0">{{ book.sasia }} në stok</span>
              <span class="book-stock" v-else style="background:rgba(196,30,58,.7)">Pa stok</span>
            </div>
          </a>

          <div class="book-body">
            <div class="book-cat-tag">{{ book.category?.emri || '—' }}</div>
            <div class="book-title">{{ book.titulli }}</div>
            <div class="book-author">
              {{ book.author?.emri || '' }} {{ book.author?.mbiemri || '' }}
            </div>
            <div class="book-bottom">
              <span class="book-price">€ {{ fmt(book.cmimi) }}</span>
              <span class="book-stars" v-if="book.reviews_avg_nota">
                <i class="bi bi-star-fill"></i>
                {{ parseFloat(book.reviews_avg_nota).toFixed(1) }}
              </span>
            </div>
            <div class="book-actions">
              <a :href="appBase + '/books/' + book.id" class="btn-view-book">
                <i class="bi bi-eye"></i> Shiko
              </a>
              <button class="btn-wish-book" title="Shto në dëshirave"
                      @click="addWishlist(book.id)">
                <i class="bi" :class="wishlist.includes(book.id) ? 'bi-heart-fill' : 'bi-heart'"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- No results -->
        <div class="no-results" v-if="filteredBooks.length === 0">
          <i class="bi bi-search" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
          Nuk u gjet asnjë libër.
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'BookBrowse',

  data() {
    return {
      books:      [],
      categories: [],
      search:     '',
      activeCat:  '',
      loading:    true,
      wishlist:   [],
      flash:      '',
      flashOk:    true,
      appBase:    window.appBase || '',
      colors: [
        ['#dbeafe', '#1d4ed8'], ['#dcfce7', '#15803d'],
        ['#fef3c7', '#b45309'], ['#fce7f3', '#9d174d'],
        ['#ede9fe', '#6d28d9'], ['#fff0f2', '#c41e3a'],
        ['#e0f2fe', '#0369a1'], ['#f0fdf4', '#166534'],
      ],
    };
  },

  computed: {
    filteredBooks() {
      const q = this.search.toLowerCase().trim();
      return this.books.filter(b => {
        const matchCat  = !this.activeCat || b.category_id == this.activeCat;
        const authorStr = ((b.author?.emri || '') + ' ' + (b.author?.mbiemri || '')).toLowerCase();
        const matchText = !q || b.titulli.toLowerCase().includes(q) || authorStr.includes(q);
        return matchCat && matchText;
      });
    },
    flashStyle() {
      return {
        background: this.flashOk ? '#d1fae5' : '#fee2e2',
      };
    },
  },

  async mounted() {
    try {
      const base = window.apiBase || '/api';
      const [bRes, cRes] = await Promise.all([
        axios.get(base + '/books'),
        axios.get(base + '/categories-list'),
      ]);
      this.books      = bRes.data;
      this.categories = cRes.data;
    } catch (e) {
      this.showFlash('Gabim gjatë ngarkimit të të dhënave.', false);
    } finally {
      this.loading = false;
    }
  },

  methods: {
    fmt(val) {
      return parseFloat(val).toFixed(2);
    },

    async addWishlist(bookId) {
      try {
        await axios.post(this.appBase + '/wishlist', {
          book_id: bookId,
          _token: document.querySelector('meta[name="csrf-token"]').content,
        });
        this.wishlist.push(bookId);
        this.showFlash('Libri u shtua në listën e dëshirave!', true);
      } catch (e) {
        const msg = e.response?.data?.message || 'Tashmë ekziston në listën e dëshirave.';
        this.showFlash(msg, false);
      }
    },

    showFlash(msg, ok = true) {
      this.flash   = msg;
      this.flashOk = ok;
      setTimeout(() => { this.flash = ''; }, 3000);
    },
  },
};
</script>
