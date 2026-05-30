<template>
  <div>
    <!-- Back link -->
    <div style="margin-bottom:16px;">
      <a :href="appBase + '/browse'" style="color:#aaa;font-size:.83rem;text-decoration:none;">
        <i class="bi bi-arrow-left"></i> Kthehu te librat
      </a>
    </div>

    <!-- Flash -->
    <div v-if="flash" :style="{ background: flashOk ? '#d1fae5' : '#fee2e2' }"
         style="border-radius:10px;padding:.7rem 1rem;margin-bottom:14px;font-size:.84rem;">
      {{ flash }}
    </div>

    <!-- Loading -->
    <div v-if="loading" style="text-align:center;padding:4rem;">
      <div class="spinner-border text-danger" style="width:2.5rem;height:2.5rem;" role="status"></div>
      <p style="color:#aaa;margin-top:.75rem;">Duke ngarkuar...</p>
    </div>

    <!-- Content -->
    <div v-else-if="book" class="book-layout">

      <!-- Cover panel -->
      <div class="book-cover-panel">
        <div class="book-cover-img">
          <i class="bi bi-book-half" style="color:var(--cherry);"></i>
        </div>
        <div class="book-price-big">€ {{ fmt(book.cmimi) }}</div>

        <a :href="appBase + '/payments/checkout/' + book.id" class="btn-buy">
          <i class="bi bi-bag-fill"></i> Bli Tani
        </a>

        <button class="btn-wish-lg" @click="addWishlist">
          <i class="bi" :class="inWishlist ? 'bi-heart-fill' : 'bi-heart-fill'"></i>
          {{ inWishlist ? 'Shtuar ✓' : 'Shto në Dëshirave' }}
        </button>

        <div style="font-size:.72rem;color:#aaa;text-align:center;">
          <template v-if="book.sasia > 0">
            <i class="bi bi-check-circle-fill" style="color:#16a34a;"></i>
            {{ book.sasia }} ekzemplarë në stok
          </template>
          <template v-else>
            <i class="bi bi-x-circle-fill" style="color:var(--cherry);"></i>
            Pa stok momentalisht
          </template>
        </div>
      </div>

      <!-- Info + reviews -->
      <div class="book-info-panel">

        <!-- Info card -->
        <div class="info-card">
          <h4 style="font-weight:900;margin:0 0 4px;">{{ book.titulli }}</h4>
          <p style="color:#aaa;font-size:.83rem;margin:0 0 14px;">
            {{ book.author?.emri || '' }} {{ book.author?.mbiemri || '' }}
            <template v-if="book.category"> · {{ book.category.emri }}</template>
          </p>

          <p v-if="book.pershkrimi"
             style="font-size:.86rem;color:#444;line-height:1.7;margin-bottom:14px;">
            {{ book.pershkrimi }}
          </p>

          <div>
            <div class="info-row">
              <span class="info-lbl">ISBN</span>
              <span class="info-val">{{ book.isbn }}</span>
            </div>
            <div class="info-row">
              <span class="info-lbl">Kategoria</span>
              <span class="info-val">{{ book.category?.emri || '—' }}</span>
            </div>
            <div class="info-row">
              <span class="info-lbl">Autori</span>
              <span class="info-val">{{ book.author?.emri || '' }} {{ book.author?.mbiemri || '' }}</span>
            </div>
            <div class="info-row">
              <span class="info-lbl">Çmimi</span>
              <span class="info-val" style="color:var(--cherry);">€ {{ fmt(book.cmimi) }}</span>
            </div>
          </div>
        </div>

        <!-- Reviews card -->
        <div class="info-card">
          <div style="font-weight:800;font-size:.95rem;margin-bottom:14px;">
            Vlerësimet
            <span v-if="avgRating" style="color:#f59e0b;font-size:.85rem;margin-left:8px;">
              <i class="bi bi-star-fill"></i> {{ avgRating }}
            </span>
            <span style="color:#aaa;font-size:.75rem;font-weight:600;">({{ reviews.length }})</span>
          </div>

          <!-- Review list -->
          <div v-if="reviews.length === 0"
               style="color:#aaa;font-size:.83rem;text-align:center;padding:1rem 0;">
            Nuk ka vlerësime ende. Ji i pari!
          </div>

          <div v-for="rev in reviews" :key="rev.id" class="rev-card">
            <div class="rev-stars">
              <i v-for="s in 5" :key="s"
                 class="bi" :class="s <= rev.nota ? 'bi-star-fill' : 'bi-star'"
                 style="color:#f59e0b;font-size:.85rem;"></i>
            </div>
            <div v-if="rev.komenti" class="rev-text">"{{ rev.komenti }}"</div>
            <div class="rev-by">
              {{ rev.user?.name || 'Anonim' }} · {{ formatDate(rev.created_at) }}
            </div>
            <div v-if="authUser && authUser.id == rev.user_id" style="margin-top:8px;">
              <button @click="deleteReview(rev.id)"
                      style="background:#fff0f2;color:var(--cherry);border:none;border-radius:6px;
                             padding:3px 10px;font-size:.72rem;font-weight:700;cursor:pointer;
                             font-family:'Nunito',sans-serif;">
                <i class="bi bi-trash3"></i> Fshi
              </button>
            </div>
          </div>

          <!-- Write review form -->
          <div v-if="authUser && !myReview"
               style="border-top:1px solid #f5f0ec;margin-top:14px;padding-top:14px;">
            <div style="font-weight:700;font-size:.85rem;margin-bottom:12px;">
              Lër Vlerësimin Tënd
            </div>
            <form @submit.prevent="submitReview">
              <label class="form-lbl">Nota</label>
              <select v-model="newReview.nota" class="form-sel" required>
                <option value="5">5 ★★★★★</option>
                <option value="4">4 ★★★★☆</option>
                <option value="3">3 ★★★☆☆</option>
                <option value="2">2 ★★☆☆☆</option>
                <option value="1">1 ★☆☆☆☆</option>
              </select>
              <label class="form-lbl">Komenti (opsional)</label>
              <textarea v-model="newReview.komenti" class="form-ta" rows="3"
                        placeholder="Çfarë mendon për këtë libër?"></textarea>
              <button type="submit" class="btn-rev" :disabled="submitting">
                <i class="bi bi-send-fill"></i>
                {{ submitting ? 'Duke dërguar...' : 'Dërgo Vlerësimin' }}
              </button>
            </form>
          </div>
        </div>

      </div>
    </div>

    <!-- Error state -->
    <div v-else style="text-align:center;padding:3rem;color:#aaa;">
      <i class="bi bi-exclamation-circle" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
      Libri nuk u gjet.
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'BookShow',
  props: {
    bookId: { type: [Number, String], required: true },
  },

  data() {
    return {
      book:       null,
      loading:    true,
      inWishlist: false,
      flash:      '',
      flashOk:    true,
      submitting: false,
      newReview:  { nota: 5, komenti: '' },
      appBase:    window.appBase || '',
      authUser:   window.authUser || null,
    };
  },

  computed: {
    reviews() {
      return this.book?.reviews || [];
    },
    avgRating() {
      if (!this.reviews.length) return null;
      const avg = this.reviews.reduce((sum, r) => sum + r.nota, 0) / this.reviews.length;
      return avg.toFixed(1);
    },
    myReview() {
      if (!this.authUser) return null;
      return this.reviews.find(r => r.user_id == this.authUser.id) || null;
    },
  },

  async mounted() {
    try {
      const base = window.apiBase || '/api';
      const res  = await axios.get(`${base}/books/${this.bookId}`);
      this.book  = res.data;
    } catch (e) {
      this.book = null;
    } finally {
      this.loading = false;
    }
  },

  methods: {
    fmt(val) {
      return parseFloat(val).toFixed(2);
    },
    formatDate(dt) {
      return new Date(dt).toLocaleDateString('sq-AL', { day:'2-digit', month:'short', year:'numeric' });
    },

    async addWishlist() {
      try {
        await axios.post(this.appBase + '/wishlist', {
          book_id: this.bookId,
          _token:  document.querySelector('meta[name="csrf-token"]').content,
        });
        this.inWishlist = true;
        this.showFlash('U shtua në listën e dëshirave!', true);
      } catch (e) {
        this.showFlash(e.response?.data?.message || 'Tashmë është në listë.', false);
      }
    },

    async submitReview() {
      this.submitting = true;
      try {
        const res = await axios.post(this.appBase + '/reviews', {
          book_id:  this.bookId,
          nota:     this.newReview.nota,
          komenti:  this.newReview.komenti,
          _token:   document.querySelector('meta[name="csrf-token"]').content,
        });
        // Rifresko librin me reviews të reja
        const base = window.apiBase || '/api';
        const bookRes = await axios.get(`${base}/books/${this.bookId}`);
        this.book = bookRes.data;
        this.newReview = { nota: 5, komenti: '' };
        this.showFlash('Vlerësimi u dërgua me sukses!', true);
      } catch (e) {
        this.showFlash(e.response?.data?.message || 'Gabim gjatë dërgimit.', false);
      } finally {
        this.submitting = false;
      }
    },

    async deleteReview(id) {
      try {
        await axios.delete(`${this.appBase}/reviews/${id}`, {
          data: { _token: document.querySelector('meta[name="csrf-token"]').content },
        });
        const base = window.apiBase || '/api';
        const res  = await axios.get(`${base}/books/${this.bookId}`);
        this.book  = res.data;
        this.showFlash('Vlerësimi u fshi.', true);
      } catch (e) {
        this.showFlash('Gabim gjatë fshirjes.', false);
      }
    },

    showFlash(msg, ok = true) {
      this.flash   = msg;
      this.flashOk = ok;
      setTimeout(() => { this.flash = ''; }, 3500);
    },
  },
};
</script>
