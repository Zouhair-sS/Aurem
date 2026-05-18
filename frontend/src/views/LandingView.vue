<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Placeholder video URL — easy to swap
const VIDEO_URL = 'https://www.w3schools.com/html/mov_bbb.mp4'

// ─── i18n ───
const lang = ref('fr')
const langOpen = ref(false)
const langFading = ref(false)
const toggleLang = () => { langOpen.value = !langOpen.value }
const setLang = (l) => {
  if (l === lang.value) { langOpen.value = false; return }
  langFading.value = true
  langOpen.value = false
  setTimeout(() => {
    lang.value = l
    setTimeout(() => { langFading.value = false }, 50)
  }, 250)
}

const t = computed(() => translations[lang.value])

const translations = {
  fr: {
    about: 'À propos',
    login: 'connexion',
    register: "s'inscrire",
    langLabel: 'Fra',
    heroTitle: 'Gérez vos finances.<br />Simplement.',
    heroSubtitle: 'Aurem est une application web de gestion financière personnelle — suivez vos revenus, dépenses et budgets en temps réel.',
    heroCta: 'how it works',
    videoLabel: "C'EST QUOI AUREM?",
    videoHeading: 'Votre référence pour mieux gérer votre argent',
    videoPlay: '▶ Voir la démo',
    featHeading: 'Tout ce dont vous avez besoin, dans une seule application',
    featSubtitle: 'Vos revenus, vos dépenses, vos objectifs — tout au même endroit. Aurem transforme vos données financières en tableaux de bord clairs, des budgets intelligents et des rapports qui parlent d\'eux-mêmes.',
    featBoxes: {
      suivi: { label: 'SUIVI', title: 'Sachez où vous en êtes', desc: 'Visualisez vos revenus et dépenses en temps réel. Chaque transaction est enregistrée, catégorisée et reflétée instantanément dans votre tableau de bord.' },
      budgets: { label: 'BUDGETS', title: 'Des budgets qui s\'adaptent à vous', desc: 'Fixez des limites par catégorie et suivez votre progression au quotidien. Aurem vous alerte avant que vous ne dépassiez vos objectifs.' },
      rapports: { label: 'RAPPORTS', title: 'Visualisez chaque centime', desc: 'Des graphiques clairs pour comprendre où part votre argent, mois après mois. Filtrez par période et identifiez vos habitudes en un coup d\'\u0153il.' },
      categories: { label: 'CATÉGORIES', title: 'Organisez à votre façon', desc: 'Créez vos propres catégories avec une icône et une couleur. Dépenses, revenus — tout est organisé exactement comme vous le souhaitez.' }
    },
    featItems: [
      { icon: '📊', title: 'Tableau de bord intelligent', desc: 'Visualisez vos finances en temps réel avec des graphiques clairs et intuitifs.', color: '#c9a84c' },
      { icon: '💸', title: 'Suivi des transactions', desc: 'Catégorisez chaque dépense et revenu en quelques secondes.', color: '#3b82f6' },
      { icon: '🎯', title: 'Budgets personnalisés', desc: 'Définissez vos limites mensuelles et recevez des alertes avant de les dépasser.', color: '#10b981' }
    ],
    featLabels: { suivi: 'Suivi en temps réel', categories: 'Catégories intelligentes', budgets: 'Budgets & alertes', rapports: 'Rapports visuels' },
    pourquoiTitle: 'POURQUOI AUREM ?',
    pourquoiSub: 'Simple . Visuel . Intelligent',
    pourquoiQuote: 'Conçu pour que vous passiez<br>moins de temps à gérer,<br>et plus de temps à avancer.',
    stackTitle: 'STACK TECHNIQUE',
    stackSub: 'Construit avec les bons outils',
    stackDesc: 'Une stack moderne, choisie pour<br>sa robustesse et sa rapidité de<br>développement.',
    adminTitle: 'PANNEAU ADMIN',
    adminSub: 'Un contrôle total sur la plateforme',
    adminDesc: "Un espace d'administration séparé,<br>sécurisé et complet — accessible<br>uniquement aux administrateurs.",
    adminCards: [
      { icon: '🔒', title: 'Accès sécurisé', desc: 'Guard Laravel séparé, credentials en <code>.env</code>, session isolée des utilisateurs normaux.' },
      { icon: '👥', title: 'Gestion des utilisateurs', desc: "Consultez, désactivez ou supprimez n'importe quel compte depuis une interface dédiée." },
      { icon: '📋', title: "Journal d'audit", desc: 'Chaque action admin est horodatée et enregistrée — rien ne passe inaperçu.' }
    ],
    ctaHeading: 'Prenez le contrôle<br>de vos finances dès aujourd\'hui.',
    ctaBtn: 'Commencez maintenant',
    footerCols: [
      { title: 'Fonctionnalités', links: ['Suivi', 'Budgets', 'Rapports', 'Catégories'] },
      { title: 'Technologies', links: ['Laravel', 'Vue.js 3', 'PostgreSQL', 'Tailwind CSS'] },
      { title: 'Projet', links: ['À propos', "L'équipe", 'Démonstration', 'Panneau Admin'] },
      { title: 'Contact', links: ['EMSI Casablanca', 'IIR — 3ème année', '2025 / 2026'] }
    ],
    footerCopy: '© 2025 Aurem. Projet académique — EMSI Casablanca.'
  },
  en: {
    about: 'About',
    login: 'login',
    register: 'sign up',
    langLabel: 'Eng',
    heroTitle: 'Manage your finances.<br />Simply.',
    heroSubtitle: 'Aurem is a personal finance management web app — track your income, expenses and budgets in real time.',
    heroCta: 'how it works',
    videoLabel: 'WHAT IS AUREM?',
    videoHeading: 'Your reference for better money management',
    videoPlay: '▶ Watch the demo',
    featHeading: 'Everything you need, in one single app',
    featSubtitle: 'Your income, your expenses, your goals — all in one place. Aurem transforms your financial data into clear dashboards, smart budgets and reports that speak for themselves.',
    featBoxes: {
      suivi: { label: 'TRACKING', title: 'Know where you stand', desc: 'See your income and expenses in real time. Every transaction is recorded, categorized and instantly reflected in your dashboard.' },
      budgets: { label: 'BUDGETS', title: 'Budgets that adapt to you', desc: 'Set limits per category and track your daily progress. Aurem alerts you before you exceed your goals.' },
      rapports: { label: 'REPORTS', title: 'Visualize every cent', desc: 'Clear charts to understand where your money goes, month after month. Filter by period and identify your habits at a glance.' },
      categories: { label: 'CATEGORIES', title: 'Organize your way', desc: 'Create your own categories with an icon and a color. Expenses, income — everything is organized exactly as you wish.' }
    },
    featItems: [
      { icon: '📊', title: 'Smart Dashboard', desc: 'Visualize your finances in real time with clear and intuitive charts.', color: '#c9a84c' },
      { icon: '💸', title: 'Transaction Tracking', desc: 'Categorize every expense and income in seconds.', color: '#3b82f6' },
      { icon: '🎯', title: 'Custom Budgets', desc: 'Set monthly limits and get alerts before you exceed them.', color: '#10b981' }
    ],
    featLabels: { suivi: 'Real-time tracking', categories: 'Smart categories', budgets: 'Budgets & alerts', rapports: 'Visual reports' },
    pourquoiTitle: 'WHY AUREM?',
    pourquoiSub: 'Simple . Visual . Intelligent',
    pourquoiQuote: 'Designed so you spend<br>less time managing,<br>and more time moving forward.',
    stackTitle: 'TECH STACK',
    stackSub: 'Built with the right tools',
    stackDesc: 'A modern stack, chosen for<br>its robustness and development<br>speed.',
    adminTitle: 'ADMIN PANEL',
    adminSub: 'Full control over the platform',
    adminDesc: 'A separate, secure and complete<br>administration space — accessible<br>only to administrators.',
    adminCards: [
      { icon: '🔒', title: 'Secure Access', desc: 'Separate Laravel guard, <code>.env</code> credentials, isolated session from normal users.' },
      { icon: '👥', title: 'User Management', desc: 'View, deactivate or delete any account from a dedicated interface.' },
      { icon: '📋', title: 'Audit Log', desc: 'Every admin action is timestamped and recorded — nothing goes unnoticed.' }
    ],
    ctaHeading: 'Take control<br>of your finances today.',
    ctaBtn: 'Get started now',
    footerCols: [
      { title: 'Features', links: ['Tracking', 'Budgets', 'Reports', 'Categories'] },
      { title: 'Technologies', links: ['Laravel', 'Vue.js 3', 'PostgreSQL', 'Tailwind CSS'] },
      { title: 'Project', links: ['About', 'Team', 'Demo', 'Admin Panel'] },
      { title: 'Contact', links: ['EMSI Casablanca', 'IIR — 3rd year', '2025 / 2026'] }
    ],
    footerCopy: '© 2025 Aurem. Academic project — EMSI Casablanca.'
  }
}

const scrollToFooter = () => {
  const el = document.getElementById('landing-footer')
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}

// Navbar scroll state
const navScrolled = ref(false)

// Active feature for fonctionnalites section
const activeFeature = ref('suivi')
const featureImages = {
  suivi: '/mockup_suivi.png',
  budgets: '/mockup_budgets.png',
  rapports: '/mockup_rapports.png',
  categories: '/mockup_categories.png'
}

// Video state
const videoRef = ref(null)
const videoPaused = ref(true)
const videoVisible = ref(false)

// Scroll handler for navbar
const onScroll = () => {
  navScrolled.value = window.scrollY > 80
}

// IntersectionObserver for video autoplay
let videoObserver = null

const initVideoObserver = () => {
  if (!videoRef.value) return
  videoObserver = new IntersectionObserver(
    ([entry]) => {
      videoVisible.value = entry.isIntersecting
      if (entry.isIntersecting) {
        videoRef.value.play()
        videoPaused.value = false
      } else {
        videoRef.value.pause()
        videoPaused.value = true
      }
    },
    { threshold: 0.4 }
  )
  videoObserver.observe(videoRef.value)
}

const toggleVideo = () => {
  if (!videoRef.value) return
  if (videoRef.value.paused) {
    videoRef.value.play()
    videoPaused.value = false
  } else {
    videoRef.value.pause()
    videoPaused.value = true
  }
}

const scrollToVideo = () => {
  const el = document.getElementById('video-section')
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}

// ─── GSAP + ScrollTrigger Animations ───
const initGSAP = () => {
  const gsap = window.gsap
  const ScrollTrigger = window.ScrollTrigger
  if (!gsap || !ScrollTrigger) return

  gsap.registerPlugin(ScrollTrigger)

  // Helper: default ScrollTrigger config
  const st = (trigger, start = 'top 85%') => ({
    scrollTrigger: { trigger, start, once: true }
  })

  // ── HERO (on load, no scroll) ──
  const heroTitle = document.querySelector('.hero-title')
  const heroSubtitle = document.querySelector('.hero-subtitle')
  const heroBtn = document.querySelector('.hero-btn')
  const heroImg = document.querySelector('.hero-image img')

  if (heroTitle) {
    gsap.fromTo(heroTitle, { y: 60, opacity: 0 }, { y: 0, opacity: 1, duration: 1.2, delay: 0.1, ease: 'power3.out' })
  }
  if (heroSubtitle) {
    gsap.fromTo(heroSubtitle, { y: 40, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, delay: 0.5, ease: 'power3.out' })
  }
  if (heroBtn) {
    gsap.fromTo(heroBtn, { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, delay: 0.7, ease: 'power3.out' })
  }
  if (heroImg) {
    gsap.fromTo(heroImg, { scale: 0.92, opacity: 0 }, { scale: 1, opacity: 1, duration: 1.4, delay: 0.4, ease: 'power2.out' })
  }

  // Helper: fromTo with ScrollTrigger
  const animIn = (el, from, to, stOpts) => {
    gsap.fromTo(el, from, { ...to, ...stOpts })
  }

  // ── VIDEO / C'EST QUOI AUREM ──
  const videoSection = document.querySelector('.video-section')
  if (videoSection) {
    const vLabel = videoSection.querySelector('.video-label')
    const vHeading = videoSection.querySelector('.video-heading')
    const vCard = videoSection.querySelector('.video-placeholder')

    if (vLabel) animIn(vLabel, { y: 20, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' }, st(vLabel))
    if (vHeading) animIn(vHeading, { y: 50, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' }, st(vHeading))
    if (vCard) animIn(vCard, { scale: 0.94, opacity: 0 }, { scale: 1, opacity: 1, duration: 1, ease: 'power2.out' }, st(vCard))
  }

  // ── FONCTIONNALITÉS ──
  const fonctSection = document.querySelector('.fonctionnalites')
  if (fonctSection) {
    const fHeading = fonctSection.querySelector('.fonctionnalites-heading')
    const fSub = fonctSection.querySelector('.fonctionnalites-subtitle')
    const leftBoxes = fonctSection.querySelectorAll('.fonctionnalites-left .feature-box')
    const rightBoxes = fonctSection.querySelectorAll('.fonctionnalites-right .feature-box')
    const centerCard = fonctSection.querySelector('.mockup-container')

    if (fHeading) animIn(fHeading, { y: 50, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' }, st(fHeading))
    if (fSub) animIn(fSub, { opacity: 0 }, { opacity: 1, duration: 0.8, delay: 0.2, ease: 'power3.out' }, st(fSub))
    if (leftBoxes.length) animIn(leftBoxes, { y: 40, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, stagger: 0.15, ease: 'power3.out' }, st(fonctSection))
    if (centerCard) animIn(centerCard, { scale: 0.9, opacity: 0 }, { scale: 1, opacity: 1, duration: 1.2, ease: 'back.out(1.2)' }, st(centerCard))
    if (rightBoxes.length) animIn(rightBoxes, { y: 40, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, stagger: 0.15, delay: 0.1, ease: 'power3.out' }, st(fonctSection))
  }

  // ── POURQUOI AUREM ──
  const pourquoiSection = document.querySelector('.pourquoi-aurem')
  if (pourquoiSection) {
    const pLeft = pourquoiSection.querySelector('.pourquoi-left')
    const pCards = pourquoiSection.querySelectorAll('.pourquoi-card')

    if (pLeft) animIn(pLeft, { x: -50, opacity: 0 }, { x: 0, opacity: 1, duration: 0.8, ease: 'power3.out' }, st(pLeft))
    if (pCards.length) animIn(pCards, { y: 50, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, stagger: 0.2, ease: 'power3.out' }, st(pourquoiSection))
  }

  // ── STACK TECHNIQUE ──
  const stackSection = document.querySelector('.stack-section')
  if (stackSection) {
    const sRight = stackSection.querySelector('.stack-right')
    const techCards = stackSection.querySelectorAll('.tech-card')

    if (sRight) animIn(sRight, { x: 50, opacity: 0 }, { x: 0, opacity: 1, duration: 0.8, ease: 'power3.out' }, st(sRight))
    if (techCards.length) animIn(techCards, { x: -40, opacity: 0 }, { x: 0, opacity: 1, duration: 0.8, stagger: 0.1, ease: 'power2.out' }, st(stackSection))
  }

  // ── PANNEAU ADMIN ──
  const adminSection = document.querySelector('.admin-section')
  if (adminSection) {
    const aLeft = adminSection.querySelector('.admin-left')
    const aCards = adminSection.querySelectorAll('.admin-card')
    const aMockup = adminSection.querySelector('.admin-mockup')

    if (aLeft) animIn(aLeft, { x: -60, opacity: 0 }, { x: 0, opacity: 1, duration: 0.8, ease: 'power3.out' }, st(aLeft))
    if (aCards.length) animIn(aCards, { x: -60, opacity: 0 }, { x: 0, opacity: 1, duration: 0.8, stagger: 0.15, ease: 'power3.out' }, st(adminSection))
    if (aMockup) animIn(aMockup, { x: 80, opacity: 0, scale: 0.95 }, { x: 0, opacity: 1, scale: 1, duration: 1.2, ease: 'power3.out' }, st(aMockup))
  }

  // ── CTA BANNER ──
  const ctaSection = document.querySelector('.final-cta-gold')
  if (ctaSection) {
    const ctaInner = ctaSection.querySelector('.final-cta-gold-inner')
    const ctaH2 = ctaSection.querySelector('.final-cta-gold-heading')
    const ctaBtn = ctaSection.querySelector('.final-cta-gold-btn')

    if (ctaInner) animIn(ctaInner, { scale: 0.95, opacity: 0 }, { scale: 1, opacity: 1, duration: 1, ease: 'power2.out' }, st(ctaInner))
    if (ctaH2) animIn(ctaH2, { y: 40, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, delay: 0.1, ease: 'power3.out' }, st(ctaH2))
    if (ctaBtn) {
      gsap.fromTo(ctaBtn,
        { y: 30, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.8, delay: 0.3, ease: 'power3.out', ...st(ctaBtn),
          onComplete: () => {
            gsap.to(ctaBtn, { scale: 1.04, duration: 2, repeat: -1, yoyo: true, ease: 'sine.inOut' })
          }
        }
      )
    }
  }

  // ── FOOTER ──
  const footer = document.querySelector('.landing-footer-new')
  if (footer) {
    const fCols = footer.querySelectorAll('.footer-col')
    const fBrand = footer.querySelector('.footer-brand')
    const fBottom = footer.querySelector('.footer-bottom')

    if (fBrand) animIn(fBrand, { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' }, st(fBrand))
    if (fCols.length) animIn(fCols, { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, stagger: 0.1, ease: 'power3.out' }, st(footer))
    if (fBottom) animIn(fBottom, { opacity: 0 }, { opacity: 1, duration: 0.8, delay: 0.4, ease: 'power3.out' }, st(fBottom))
  }
}

onMounted(() => {
  window.addEventListener('scroll', onScroll, { passive: true })
  requestAnimationFrame(() => {
    initVideoObserver()
    initGSAP()
  })
})

onUnmounted(() => {
  window.removeEventListener('scroll', onScroll)
  if (videoObserver) videoObserver.disconnect()
  if (window.ScrollTrigger) window.ScrollTrigger.getAll().forEach(t => t.kill())
})

const features = [
  {
    icon: '📊',
    title: 'Tableau de bord intelligent',
    desc: 'Visualisez vos finances en temps réel avec des graphiques clairs et intuitifs.',
    color: '#c9a84c'
  },
  {
    icon: '💸',
    title: 'Suivi des transactions',
    desc: 'Catégorisez chaque dépense et revenu en quelques secondes.',
    color: '#3b82f6'
  },
  {
    icon: '🎯',
    title: 'Budgets personnalisés',
    desc: 'Définissez vos limites mensuelles et recevez des alertes avant de les dépasser.',
    color: '#10b981'
  }
]

const techs = [
  { name: 'Laravel',      desc: 'Backend & API REST',      badge: 'Backend',  icon: '/laravel.svg',  color: '#c9a84c' },
  { name: 'Vue.js 3',     desc: 'Frontend SPA',            badge: 'Frontend', icon: '/vue.svg',      color: '#42b883' },
  { name: 'PostgreSQL',   desc: 'Base de données',         badge: 'Database', icon: '/sql.svg',      color: '#8b7d3c' },
  { name: 'Vite',         desc: 'Build tool & Dev server', badge: 'Tooling',  icon: '/vite.svg',     color: '#a855f7' },
  { name: 'Chart.js',     desc: 'Graphiques & rapports',   badge: 'Charts',   icon: '/chartjs.svg',  color: '#f97316' },
  { name: 'Tailwind CSS', desc: 'Styling & UI',            badge: 'Styling',  icon: '/tailwind.svg', color: '#38bdf8' },
]

const stats = [
  { value: '100% Privé', label: 'Vos données restent chez vous' },
  { value: '0€', label: 'Gratuit pour commencer' },
  { value: '5 min', label: 'Pour configurer votre compte' }
]
</script>

<template>
  <div class="landing-page" :class="{ 'lang-fading': langFading }">
    <!-- ═══════════ NAVBAR ═══════════ -->
    <nav class="landing-nav" :class="{ scrolled: navScrolled }">
      <div class="nav-inner">
        <router-link to="/" class="nav-logo">
          <img src="/aurem-logo-nav.png" alt="Aurem" class="nav-logo-img" />
        </router-link>
        <div class="nav-center">
          <a href="#landing-footer" class="nav-link" @click.prevent="scrollToFooter">{{ t.about }}</a>
          <router-link to="/login" class="nav-link">{{ t.login }}</router-link>
          <div class="nav-lang" @click="toggleLang">
            <span>{{ t.langLabel }}</span>
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" :style="{ transform: langOpen ? 'rotate(180deg)' : '', transition: 'transform 0.2s' }">
              <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div v-if="langOpen" class="lang-dropdown">
              <div class="lang-option" :class="{ active: lang === 'fr' }" @click.stop="setLang('fr')">🇫🇷 Français</div>
              <div class="lang-option" :class="{ active: lang === 'en' }" @click.stop="setLang('en')">🇬🇧 English</div>
            </div>
          </div>
        </div>
        <div class="nav-actions">
          <router-link to="/register" class="nav-btn nav-btn-filled" id="landing-register-btn">
            {{ t.register }}
          </router-link>
        </div>
      </div>
    </nav>

    <!-- ═══════════ HERO ═══════════ -->
    <section class="hero">
      <div class="hero-inner">
        <div class="hero-content">
          <h1 class="hero-title" v-html="t.heroTitle"></h1>
          <p class="hero-subtitle">{{ t.heroSubtitle }}</p>
          <button class="hero-btn" @click="scrollToVideo">
            {{ t.heroCta }}
          </button>
        </div>
        <div class="hero-image">
          <img src="/wallet.png" alt="Aurem Wallet" />
        </div>
      </div>
    </section>

    <!-- ═══════════ VIDEO DEMO ═══════════ -->
    <section class="video-section" id="video-section">
      <span class="video-label">{{ t.videoLabel }}</span>
      <h2 class="video-heading">{{ t.videoHeading }}</h2>
      <div class="video-placeholder browser-mockup">
        <div class="browser-toolbar">
          <div class="browser-dots">
            <span class="dot dot-red"></span>
            <span class="dot dot-yellow"></span>
            <span class="dot dot-green"></span>
          </div>
          <div class="browser-nav">
            <span class="nav-arrow">‹</span>
            <span class="nav-arrow">›</span>
          </div>
          <div class="browser-address-bar">
            <svg class="lock-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </div>
          <div class="browser-actions">
            <svg class="refresh-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
            <svg class="menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          </div>
        </div>
        <div class="browser-content video-container">
          <video 
            ref="videoRef"
            class="demo-video"
            src="/demo-video.mp4"
            muted
            playsinline
            @click="toggleVideo"
          ></video>
          <div class="video-overlay" v-if="videoPaused" @click="toggleVideo">
            <svg class="play-icon" viewBox="0 0 24 24" fill="currentColor">
              <path d="M8 5v14l11-7z" />
            </svg>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════ FONCTIONNALITÉS ═══════════ -->
    <section class="fonctionnalites">
      <h2 class="fonctionnalites-heading">{{ t.featHeading }}</h2>
      <p class="fonctionnalites-subtitle">{{ t.featSubtitle }}</p>
      <div class="fonctionnalites-grid">
        <div class="fonctionnalites-left">
          <div 
            class="feature-box"
            @mouseenter="activeFeature = 'suivi'"
          >
            <span class="feature-box-label">{{ t.featBoxes.suivi.label }}</span>
            <h3 class="feature-box-title">{{ t.featBoxes.suivi.title }}</h3>
            <p class="feature-box-desc">{{ t.featBoxes.suivi.desc }}</p>
          </div>
          <div 
            class="feature-box"
            @mouseenter="activeFeature = 'budgets'"
          >
            <span class="feature-box-label">{{ t.featBoxes.budgets.label }}</span>
            <h3 class="feature-box-title">{{ t.featBoxes.budgets.title }}</h3>
            <p class="feature-box-desc">{{ t.featBoxes.budgets.desc }}</p>
          </div>
        </div>
        <div class="fonctionnalites-center">
          <div class="mockup-container">
            <img 
              v-for="(img, key) in featureImages" 
              :key="key"
              :src="img" 
              :alt="key"
              class="mockup-img"
              :class="{ active: activeFeature === key }"
            />
          </div>
        </div>
        <div class="fonctionnalites-right">
          <div 
            class="feature-box"
            @mouseenter="activeFeature = 'rapports'"
          >
            <span class="feature-box-label">{{ t.featBoxes.rapports.label }}</span>
            <h3 class="feature-box-title">{{ t.featBoxes.rapports.title }}</h3>
            <p class="feature-box-desc">{{ t.featBoxes.rapports.desc }}</p>
          </div>
          <div 
            class="feature-box"
            @mouseenter="activeFeature = 'categories'"
          >
            <span class="feature-box-label">{{ t.featBoxes.categories.label }}</span>
            <h3 class="feature-box-title">{{ t.featBoxes.categories.title }}</h3>
            <p class="feature-box-desc">{{ t.featBoxes.categories.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════ POURQUOI AUREM ═══════════ -->
    <section class="pourquoi-aurem">
      <div class="pourquoi-grid">
        <div class="pourquoi-left">
          <h2 class="pourquoi-title">{{ t.pourquoiTitle }}</h2>
          <p class="pourquoi-subtitle">{{ t.pourquoiSub }}</p>
          <p class="pourquoi-quote" v-html="t.pourquoiQuote"></p>
        </div>
        <div class="pourquoi-right">
          <div class="pourquoi-card card-simplicite">
            <img src="/simplicite.png" alt="Simplicité" class="pourquoi-card-img" />
          </div>
          <div class="pourquoi-card card-visualisation">
            <img src="/visualisation.png" alt="Visualisation" class="pourquoi-card-img" />
          </div>
          <div class="pourquoi-card card-controle">
            <img src="/controle.png" alt="Contrôle" class="pourquoi-card-img" />
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════ STACK TECHNIQUE ═══════════ -->
    <section class="stack-section">
      <div class="stack-grid">
        <div class="stack-left">
          <div v-for="tech in techs" :key="tech.name" class="tech-card">
            <img :src="tech.icon" :alt="tech.name" class="tech-logo" />
            <div class="tech-info">
              <span class="tech-name">{{ tech.name }}</span>
              <span class="tech-desc">{{ tech.desc }}</span>
            </div>
            <span class="tech-badge" :style="{ color: tech.color }">{{ tech.badge }}</span>
            <div class="tech-bar" :style="{ background: tech.color }"></div>
          </div>
        </div>
        <div class="stack-right">
          <h2 class="stack-title">{{ t.stackTitle }}</h2>
          <p class="stack-subtitle">{{ t.stackSub }}</p>
          <p class="stack-desc" v-html="t.stackDesc"></p>
        </div>
      </div>
    </section>

    <!-- ═══════════ PANNEAU ADMIN ═══════════ -->
    <section class="admin-section">
      <div class="admin-top">
        <div class="admin-left">
          <h2 class="admin-title">{{ t.adminTitle }}</h2>
          <p class="admin-subtitle">{{ t.adminSub }}</p>
          <p class="admin-desc" v-html="t.adminDesc"></p>
        </div>
        <div class="admin-right">
          <img src="/dashboard-admin.png" alt="Dashboard Admin" class="admin-mockup" />
        </div>
      </div>
      <div class="admin-cards">
        <div v-for="(card, i) in t.adminCards" :key="i" class="admin-card">
          <div class="admin-card-icon" :class="['admin-card-icon--lock', 'admin-card-icon--users', 'admin-card-icon--audit'][i]">{{ card.icon }}</div>
          <h3 class="admin-card-title">{{ card.title }}</h3>
          <p class="admin-card-desc" v-html="card.desc"></p>
        </div>
      </div>
    </section>

    <!-- ═══════════ FINAL CTA ═══════════ -->
    <section class="final-cta-gold">
      <div class="final-cta-gold-inner">
        <h2 class="final-cta-gold-heading" v-html="t.ctaHeading"></h2>
        <router-link to="/register" class="final-cta-gold-btn" id="final-cta-btn">
          {{ t.ctaBtn }}
        </router-link>
      </div>
    </section>

    <!-- ═══════════ FOOTER ═══════════ -->
    <footer id="landing-footer" class="landing-footer-new">
      <div class="footer-top">
        <div class="footer-brand">
          <img src="/aurem-logo.png" alt="Aurem" class="footer-logo-new" />
        </div>
        <div v-for="col in t.footerCols" :key="col.title" class="footer-col">
          <h4 class="footer-col-title">{{ col.title }}</h4>
          <span v-for="link in col.links" :key="link" class="footer-col-link">{{ link }}</span>
        </div>
      </div>
      <div class="footer-bottom">
        <span class="footer-copy-new">{{ t.footerCopy }}</span>
      </div>
    </footer>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap');

/* ─────────────────────────────────────────
   DESIGN TOKENS
   ───────────────────────────────────────── */
:root {
  --navy: #1a2332;
  --offwhite: #f5f3ef;
  --gold: #c9a84c;
  --gray: #6b7280;
}

.landing-page {
  --navy: #1a2332;
  --offwhite: #f5f3ef;
  --gold: #c9a84c;
  --gray: #6b7280;
  background: white;
  color: var(--navy);
  overflow-x: hidden;
  min-height: 100vh;
  position: relative;
  font-family: 'Inter', sans-serif;
}

/* Language fade transition — scoped to lang-fading only */
.landing-page.lang-fading h1,
.landing-page.lang-fading h2,
.landing-page.lang-fading h3,
.landing-page.lang-fading h4,
.landing-page.lang-fading p,
.landing-page.lang-fading span,
.landing-page.lang-fading a,
.landing-page.lang-fading button {
  opacity: 0 !important;
  transition: opacity 0.25s ease;
}

/* ─────────────────────────────────────────
   GSAP ANIMATED ELEMENTS — GPU hints
   ───────────────────────────────────────── */
.hero-title,
.hero-subtitle,
.hero-btn,
.hero-image img,
.video-label,
.video-heading,
.video-placeholder,
.fonctionnalites-heading,
.fonctionnalites-subtitle,
.feature-box,
.mockup-container,
.pourquoi-left,
.pourquoi-card,
.stack-right,
.tech-card,
.admin-left,
.admin-card,
.admin-mockup,
.final-cta-gold-inner,
.final-cta-gold-heading,
.final-cta-gold-btn,
.footer-brand,
.footer-col,
.footer-bottom {
  will-change: transform, opacity;
}

/* ─────────────────────────────────────────
   SCROLL ANIMATION (legacy fallback)
   ───────────────────────────────────────── */
.fade-up {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.5s ease var(--delay, 0ms),
              transform 0.5s ease var(--delay, 0ms);
}
.fade-up.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* ─────────────────────────────────────────
   NAVBAR
   ───────────────────────────────────────── */
.landing-nav {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 100;
  padding: 0 48px;
  height: 100px;
  display: flex;
  align-items: center;
  background: white;
  transition: background 0.3s ease, box-shadow 0.3s ease, backdrop-filter 0.3s ease;
}
.landing-nav.scrolled {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
}
.nav-inner {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.nav-logo {
  display: flex;
  align-items: center;
  text-decoration: none;
}
.nav-logo-img {
  height: 64px;
  width: auto;
  object-fit: contain;
}
.nav-center {
  display: flex;
  align-items: center;
  gap: 40px;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}
.nav-link {
  font-family: 'Playfair Display', serif;
  font-size: 15px;
  font-weight: 500;
  color: var(--navy);
  text-decoration: none;
  transition: color 0.2s ease, opacity 0.3s ease;
  min-width: 70px;
  text-align: center;
}
.nav-link:hover {
  color: var(--gold);
}
.nav-lang {
  display: flex;
  align-items: center;
  gap: 6px;
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 500;
  color: var(--navy);
  cursor: pointer;
  position: relative;
}
.lang-dropdown {
  position: absolute;
  top: calc(100% + 8px);
  right: 0;
  background: white;
  border-radius: 12px;
  box-shadow: 0 8px 28px rgba(0,0,0,0.12);
  border: 1px solid rgba(0,0,0,0.06);
  padding: 6px;
  min-width: 150px;
  z-index: 100;
}
.lang-option {
  padding: 8px 14px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  color: var(--navy);
  transition: background 0.15s;
  cursor: pointer;
}
.lang-option:hover {
  background: var(--offwhite);
}
.lang-option.active {
  color: var(--gold);
  font-weight: 600;
}
.nav-actions {
  display: flex;
  align-items: center;
}
.nav-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 40px;
  padding: 0 24px;
  min-width: 100px;
  border-radius: 999px;
  font-family: 'Playfair Display', serif;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  text-decoration: none;
  box-shadow: 0 3px 0 rgba(0,0,0,0.15);
}
.nav-btn-filled {
  background: white;
  color: var(--navy);
  border: 1.5px solid var(--navy);
}
.nav-btn-filled:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 0 rgba(0,0,0,0.15);
}

/* ─────────────────────────────────────────
   HERO
   ───────────────────────────────────────── */
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  padding: 120px 48px 80px;
  background: white;
  overflow: hidden;
}
.hero-inner {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}
.hero-content {
  display: flex;
  flex-direction: column;
  gap: 24px;
}
.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: 80px;
  font-weight: 400;
  line-height: 1.1;
  color: var(--navy);
  margin: 0;
  letter-spacing: -1px;
  white-space: nowrap;
  transition: opacity 0.3s ease;
}
.hero-subtitle {
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  font-weight: 400;
  color: var(--gray);
  line-height: 1.6;
  max-width: 420px;
  min-height: 52px;
  margin: 0;
  transition: opacity 0.3s ease;
}
.hero-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 44px;
  padding: 0 28px;
  border-radius: 999px;
  font-family: 'Playfair Display', serif;
  font-size: 15px;
  font-weight: 500;
  color: var(--navy);
  background: white;
  border: 1.5px solid #e5e0d8;
  cursor: pointer;
  transition: all 0.25s ease;
  text-decoration: none;
  width: fit-content;
  box-shadow: 0 2px 0 rgba(0,0,0,0.05);
}
.hero-btn:hover {
  border-color: var(--navy);
  transform: translateY(-1px);
}
.hero-image {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
}
.hero-image img {
  max-width: 100%;
  height: auto;
  max-height: 620px;
  object-fit: contain;
}

/* ─────────────────────────────────────────
   VIDEO SECTION
   ───────────────────────────────────────── */
.video-section {
  padding: 80px 24px 100px;
  max-width: 1200px;
  margin: 0 auto;
  text-align: center;
}
.video-label {
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 0.15em;
  color: var(--gold);
  text-transform: uppercase;
  margin-bottom: 16px;
  display: block;
}
.video-heading {
  font-family: 'Playfair Display', serif;
  font-size: 42px;
  font-weight: 400;
  color: var(--navy);
  margin-bottom: 48px;
  line-height: 1.2;
}
.video-placeholder {
  background: #fff;
  border-radius: 16px;
  min-height: 450px;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08), 0 2px 12px rgba(0, 0, 0, 0.04);
}
.browser-toolbar {
  display: flex;
  align-items: center;
  padding: 14px 20px;
  background: #f5f5f5;
  border-bottom: 1px solid #e8e8e8;
  border-radius: 16px 16px 0 0;
  gap: 14px;
}
.browser-dots {
  display: flex;
  gap: 7px;
}
.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
}
.dot-red { background: #ff5f57; }
.dot-yellow { background: #febc2e; }
.dot-green { background: #28c840; }
.browser-nav {
  display: flex;
  gap: 6px;
}
.nav-arrow {
  font-size: 18px;
  color: #bbb;
  cursor: default;
  line-height: 1;
  user-select: none;
}
.browser-address-bar {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff;
  border-radius: 6px;
  padding: 6px 14px;
  border: 1px solid #e0e0e0;
}
.browser-actions {
  display: flex;
  align-items: center;
  gap: 12px;
}
.browser-content {
  flex: 1;
  min-height: 560px;
  background: #000;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}
.demo-video {
  width: 100%;
  height: 100%;
  object-fit: cover;
  cursor: pointer;
}
.video-overlay {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 0, 0, 0.4);
  cursor: pointer;
  transition: background 0.3s ease;
}
.video-overlay:hover {
  background: rgba(0, 0, 0, 0.2);
}
.play-icon {
  width: 64px;
  height: 64px;
  color: white;
  opacity: 0.9;
  transition: transform 0.2s ease;
}
.video-overlay:hover .play-icon {
  transform: scale(1.1);
}

/* ─────────────────────────────────────────
   FONCTIONNALITÉS
   ───────────────────────────────────────── */
.fonctionnalites {
  padding: 100px 48px 120px;
  max-width: 1200px;
  margin: 0 auto;
  text-align: center;
}
.fonctionnalites-heading {
  font-family: 'Playfair Display', serif;
  font-size: 40px;
  font-weight: 400;
  color: var(--navy);
  margin-bottom: 16px;
  line-height: 1.2;
  min-height: 48px;
}
.fonctionnalites-subtitle {
  font-family: 'Inter', sans-serif;
  font-size: 15px;
  font-weight: 400;
  color: var(--gray);
  max-width: 680px;
  margin: 0 auto 56px;
  line-height: 1.6;
  min-height: 72px;
}
.fonctionnalites-grid {
  display: grid;
  grid-template-columns: 260px 1fr 260px;
  gap: 48px;
  align-items: center;
}
.fonctionnalites-left,
.fonctionnalites-right {
  display: flex;
  flex-direction: column;
  gap: 32px;
}
.feature-box {
  text-align: left;
  padding: 0;
  cursor: pointer;
  transition: opacity 0.3s ease;
}
.feature-box:hover {
  opacity: 0.8;
}
.feature-box-label {
  font-family: 'Inter', sans-serif;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.12em;
  color: var(--gold);
  text-transform: uppercase;
  margin-bottom: 8px;
  display: block;
}
.feature-box-title {
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  font-weight: 600;
  color: var(--navy);
  margin-bottom: 8px;
}
.feature-box-desc {
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  color: var(--gray);
  line-height: 1.5;
  margin: 0;
}
.fonctionnalites-center {
  display: flex;
  justify-content: center;
  align-items: center;
}
.mockup-container {
  position: relative;
  width: 320px;
  height: 420px;
  border-radius: 28px;
  overflow: hidden;
  background: transparent;
}
.mockup-img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: contain;
  opacity: 0;
  transform: translateY(20px) scale(0.95);
  pointer-events: none;
  z-index: 1;
  transition: opacity 0.5s ease-out, transform 0.5s ease-out;
  border-radius: 28px;
  image-rendering: -webkit-optimize-contrast;
  image-rendering: crisp-edges;
}
.mockup-img.active {
  opacity: 1;
  transform: translateY(0) scale(1);
  pointer-events: auto;
  z-index: 10;
}

/* ─────────────────────────────────────────
   POURQUOI AUREM
   ───────────────────────────────────────── */
.pourquoi-aurem {
  padding: 100px 48px 120px;
  max-width: 1200px;
  margin: 0 auto;
}
.pourquoi-grid {
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  gap: 80px;
  align-items: start;
}
.pourquoi-left {
  padding-top: 40px;
}
.pourquoi-title {
  font-family: 'Playfair Display', serif;
  font-size: 32px;
  font-weight: 400;
  color: var(--gold);
  letter-spacing: 0.05em;
  margin-bottom: 12px;
}
.pourquoi-subtitle {
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  font-weight: 400;
  color: var(--gray);
  margin-bottom: 48px;
}
.pourquoi-quote {
  font-family: 'Playfair Display', serif;
  font-size: 26px;
  font-weight: 400;
  color: var(--navy);
  line-height: 1.4;
}
.pourquoi-right {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: auto auto;
  gap: 24px;
  position: relative;
  padding-top: 20px;
}
.pourquoi-card {
  background: transparent;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.pourquoi-card:hover {
  transform: translateY(calc(var(--translate-y) - 8px)) scale(1.02);
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.14);
}
.card-simplicite {
  grid-column: 2;
  grid-row: 1;
  transform: translateY(-20px);
  --translate-y: -20px;
}
.card-visualisation {
  grid-column: 2;
  grid-row: 2;
  transform: translateY(-10px);
  --translate-y: -10px;
}
.card-controle {
  grid-column: 1;
  grid-row: 2;
  transform: translateY(40px);
  --translate-y: 40px;
}
.pourquoi-card-img {
  width: 100%;
  height: auto;
  display: block;
  object-fit: cover;
  border-radius: 24px;
  image-rendering: -webkit-optimize-contrast;
  image-rendering: crisp-edges;
  mix-blend-mode: multiply;
}

/* ─────────────────────────────────────────
   STACK TECHNIQUE
   ───────────────────────────────────────── */
.stack-section {
  padding: 100px 48px 120px;
  max-width: 1200px;
  margin: 0 auto;
}
.stack-grid {
  display: grid;
  grid-template-columns: 1.1fr 1fr;
  gap: 80px;
  align-items: center;
}
.stack-left {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.tech-card {
  display: grid;
  grid-template-columns: 44px 1fr auto;
  grid-template-rows: auto auto;
  align-items: center;
  gap: 0 14px;
  background: white;
  border-radius: 14px;
  padding: 18px 24px 14px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.05);
  border: 1px solid rgba(0,0,0,0.04);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.tech-card:hover {
  transform: translateX(6px);
  box-shadow: 0 6px 24px rgba(0,0,0,0.1);
}
.tech-logo {
  grid-column: 1;
  grid-row: 1 / 3;
  width: 36px;
  height: 36px;
  object-fit: contain;
}
.tech-info {
  grid-column: 2;
  grid-row: 1;
  display: flex;
  flex-direction: column;
  gap: 1px;
}
.tech-name {
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  font-weight: 600;
  color: var(--navy);
}
.tech-desc {
  font-family: 'Inter', sans-serif;
  font-size: 11px;
  color: var(--gray);
}
.tech-badge {
  grid-column: 3;
  grid-row: 1;
  font-family: 'Inter', sans-serif;
  font-size: 11px;
  font-weight: 500;
  font-style: italic;
}
.tech-bar {
  grid-column: 2 / 4;
  grid-row: 2;
  height: 3px;
  border-radius: 2px;
  margin-top: 10px;
  opacity: 0.7;
}
.stack-right {
  padding-left: 20px;
}
.stack-title {
  font-family: 'Playfair Display', serif;
  font-size: 28px;
  font-weight: 400;
  color: var(--gold);
  letter-spacing: 0.08em;
  margin-bottom: 8px;
}
.stack-subtitle {
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  color: var(--gray);
  margin-bottom: 36px;
}
.stack-desc {
  font-family: 'Playfair Display', serif;
  font-size: 28px;
  font-weight: 400;
  color: var(--navy);
  line-height: 1.4;
}

/* ─────────────────────────────────────────
   PANNEAU ADMIN
   ───────────────────────────────────────── */
.admin-section {
  padding: 100px 48px 80px;
  max-width: 1200px;
  margin: 0 auto;
}
.admin-top {
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  gap: 60px;
  align-items: center;
  margin-bottom: 60px;
}
.admin-left {
  padding-top: 20px;
}
.admin-title {
  font-family: 'Playfair Display', serif;
  font-size: 32px;
  font-weight: 400;
  color: var(--navy);
  letter-spacing: 0.05em;
  margin-bottom: 8px;
}
.admin-subtitle {
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  color: var(--gold);
  margin-bottom: 32px;
}
.admin-desc {
  font-family: 'Playfair Display', serif;
  font-size: 28px;
  font-weight: 400;
  color: var(--navy);
  line-height: 1.4;
}
.admin-right {
  display: flex;
  justify-content: center;
}
.admin-mockup {
  width: 100%;
  max-width: 480px;
  height: auto;
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.1);
  image-rendering: -webkit-optimize-contrast;
}
.admin-cards {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}
.admin-card {
  background: var(--navy);
  border-radius: 20px;
  padding: 32px 28px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.admin-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 32px rgba(26,35,50,0.3);
}
.admin-card-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  margin-bottom: 18px;
}
.admin-card-icon--lock {
  background: rgba(201,168,76,0.15);
}
.admin-card-icon--users {
  background: rgba(201,168,76,0.15);
}
.admin-card-icon--audit {
  background: rgba(201,168,76,0.15);
}
.admin-card-title {
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  font-weight: 600;
  color: white;
  margin-bottom: 10px;
}
.admin-card-desc {
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  color: rgba(255,255,255,0.65);
  line-height: 1.6;
  margin: 0;
}
.admin-card-desc code {
  background: rgba(201,168,76,0.2);
  color: var(--gold);
  padding: 1px 6px;
  border-radius: 4px;
  font-size: 12px;
}

/* ─────────────────────────────────────────
   FINAL CTA GOLD
   ───────────────────────────────────────── */
.final-cta-gold {
  padding: 60px 48px 80px;
  max-width: 1200px;
  margin: 0 auto;
}
.final-cta-gold-inner {
  background: var(--gold);
  border-radius: 24px;
  padding: 80px 48px;
  text-align: center;
}
.final-cta-gold-heading {
  font-family: 'Playfair Display', serif;
  font-size: 44px;
  font-weight: 400;
  color: white;
  line-height: 1.25;
  margin-bottom: 40px;
}
.final-cta-gold-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 52px;
  padding: 0 40px;
  background: white;
  color: var(--navy);
  border-radius: 999px;
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  border: 2px solid var(--navy);
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.final-cta-gold-btn:hover {
  background: var(--navy);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(26, 35, 50, 0.25);
}

/* ─────────────────────────────────────────
   FOOTER
   ───────────────────────────────────────── */
.landing-footer-new {
  background: #e8e6e1;
  padding: 60px 48px 32px;
}
.footer-top {
  max-width: 1200px;
  margin: 0 auto 40px;
  display: grid;
  grid-template-columns: 1.5fr 1fr 1fr 1fr 1fr;
  gap: 40px;
  align-items: start;
}
.footer-brand {
  display: flex;
  align-items: center;
  gap: 12px;
}
.footer-logo-new {
  height: 44px;
  width: auto;
  object-fit: contain;
}
.footer-brand-text {
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  font-weight: 600;
  letter-spacing: 0.15em;
  color: var(--navy);
}
.footer-col {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.footer-col-title {
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  font-weight: 600;
  color: var(--navy);
  margin: 0 0 8px;
}
.footer-col-link {
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  color: var(--gray);
  cursor: default;
}
.footer-bottom {
  max-width: 1200px;
  margin: 0 auto;
  padding-top: 24px;
  border-top: 1px solid rgba(0,0,0,0.08);
  text-align: right;
}
.footer-copy-new {
  font-family: 'Inter', sans-serif;
  font-size: 12px;
  color: var(--gray);
}

/* ─────────────────────────────────────────
   RESPONSIVE
   ───────────────────────────────────────── */
@media (max-width: 1024px) {
  .hero-inner {
    grid-template-columns: 1fr;
    gap: 40px;
    text-align: center;
  }
  .hero-content {
    align-items: center;
  }
  .hero-subtitle {
    max-width: 100%;
  }
  .hero-image {
    order: -1;
  }
  .hero-image img {
    max-height: 400px;
  }
  .hero-title {
    font-size: 64px;
    white-space: normal;
  }
}

@media (max-width: 1024px) {
  .fonctionnalites-grid {
    grid-template-columns: 1fr;
    gap: 40px;
  }
  .fonctionnalites-left,
  .fonctionnalites-right {
    flex-direction: row;
    justify-content: center;
    gap: 40px;
  }
  .feature-box {
    max-width: 280px;
    text-align: center;
  }
  .fonctionnalites-center {
    order: -1;
  }
  .mockup-container {
    width: 300px;
    height: 380px;
    border-radius: 24px;
  }
  .mockup-img {
    border-radius: 24px;
  }
  .pourquoi-grid {
    grid-template-columns: 1fr;
    gap: 60px;
  }
  .pourquoi-left {
    text-align: center;
    padding-top: 0;
  }
  .pourquoi-quote {
    max-width: 500px;
    font-size: 28px;
    margin: 0 auto;
  }
  .pourquoi-right {
    max-width: 600px;
    margin: 0 auto;
  }
  .card-simplicite {
    transform: translateY(-15px);
  }
  .card-visualisation {
    transform: translateY(-10px);
  }
  .card-controle {
    transform: translateY(20px);
  }
}

@media (max-width: 900px) {
  .fonctionnalites-heading {
    font-size: 32px;
  }
  .video-heading {
    font-size: 32px;
  }
  .video-placeholder {
    min-height: 320px;
  }
  .hero-title {
    font-size: 48px;
  }
  .section-heading {
    font-size: 28px;
  }
  .final-cta-gold-heading {
    font-size: 32px;
  }
  .admin-top {
    grid-template-columns: 1fr;
    gap: 40px;
  }
  .admin-cards {
    grid-template-columns: 1fr;
  }
  .stack-grid {
    grid-template-columns: 1fr;
    gap: 60px;
  }
  .footer-top {
    grid-template-columns: 1fr 1fr;
    gap: 32px;
  }
  .nav-center {
    gap: 24px;
  }
}

@media (max-width: 768px) {
  .nav-center {
    display: none;
  }
}

@media (max-width: 600px) {
  .landing-nav {
    padding: 0 20px;
    height: 80px;
  }
  .nav-logo-img {
    height: 48px;
  }
  .nav-btn {
    height: 36px;
    padding: 0 18px;
    font-size: 14px;
  }
  .hero {
    padding: 100px 20px 60px;
  }
  .hero-title {
    font-size: 36px;
  }
  .hero-subtitle {
    font-size: 15px;
  }
  .hero-btn {
    height: 42px;
    padding: 0 24px;
    font-size: 14px;
  }
  .fonctionnalites {
    padding: 60px 20px 80px;
  }
  .fonctionnalites-heading {
    font-size: 26px;
  }
  .fonctionnalites-left,
  .fonctionnalites-right {
    flex-direction: column;
    align-items: center;
    gap: 24px;
  }
  .feature-box {
    max-width: 100%;
    text-align: center;
  }
  .mockup-container {
    width: 280px;
    height: 340px;
    border-radius: 20px;
  }
  .mockup-img {
    border-radius: 20px;
  }
  .video-section {
    padding: 60px 20px 80px;
  }
  .video-heading {
    font-size: 26px;
    margin-bottom: 36px;
  }
  .video-placeholder {
    min-height: 280px;
  }
  .video-placeholder-title {
    font-size: 22px;
  }
  .final-cta-gold {
    padding: 40px 20px 60px;
  }
  .final-cta-gold-inner {
    padding: 50px 24px;
  }
  .final-cta-gold-heading {
    font-size: 26px;
  }
  .landing-footer-new {
    padding: 40px 20px 24px;
  }
  .footer-top {
    grid-template-columns: 1fr;
    gap: 28px;
  }
  .admin-section {
    padding: 60px 20px 60px;
  }
  .admin-desc {
    font-size: 22px;
  }
  .pourquoi-aurem {
    padding: 60px 20px 80px;
  }
  .pourquoi-title {
    font-size: 26px;
  }
  .pourquoi-quote {
    font-size: 26px;
  }
  .pourquoi-right {
    grid-template-columns: 1fr;
    gap: 20px;
  }
  .card-simplicite,
  .card-visualisation,
  .card-controle {
    grid-column: 1;
    grid-row: auto;
    transform: none;
  }
}
</style>
