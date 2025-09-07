// تخزين الحجوزات
let appointments = [];

// كائن الترجمات
const translations = {
    en: {
        "nav-logo": "My Clinic",
        "nav-home": "Home",
        "nav-doctors": "Doctors",
        "nav-appointment": "Book Appointment",
        "nav-manage": "Manage Bookings",
        "nav-contact": "Contact Us",
        "hero-title": "Welcome to My Clinic",
        "hero-tagline": "Your health is our priority. We provide the best medical care for you and your family.",
        "hero-cta": "Book Appointment",
        "services-title": "Our Services",
        "service1-title": "General Checkup",
        "service1-desc": "Comprehensive health checkups to maintain your well-being.",
        "service2-title": "Dental Care",
        "service2-desc": "Professional dental services for a bright and healthy smile.",
        "service3-title": "Orthopedic Surgery",
        "service3-desc": "Specialized care for bones, joints, and muscles.",
        "testimonials-title": "What Our Patients Say",
        "testimonial1": "Best clinic I've ever visited. Highly recommend!",
        "testimonial1-author": "- Ahmed",
        "testimonial2": "Friendly staff and excellent service. Thank you!",
        "testimonial2-author": "- Sarah",
        "footer-contact": "Contact us: 0123456789 | Email: info@myclinic.com",
    },
    ar: {
        "nav-logo": "عيادتي",
        "nav-home": "الرئيسية",
        "nav-doctors": "الأطباء",
        "nav-appointment": "حجز موعد",
        "nav-manage": "إدارة الحجوزات",
        "nav-contact": "اتصل بنا",
        "hero-title": "مرحبًا بكم في عيادتي",
        "hero-tagline": "صحتك هي أولويتنا. نقدم أفضل رعاية طبية لك ولعائلتك.",
        "hero-cta": "احجز موعد",
        "services-title": "خدماتنا",
        "service1-title": "فحص عام",
        "service1-desc": "فحوصات صحية شاملة للحفاظ على صحتك.",
        "service2-title": "رعاية الأسنان",
        "service2-desc": "خدمات أسنان احترافية لابتسامة مشرقة وصحية.",
        "service3-title": "جراحة العظام",
        "service3-desc": "رعاية متخصصة للعظام والمفاصل والعضلات.",
        "testimonials-title": "ما يقوله مرضانا",
        "testimonial1": "أفضل عيادة زرتها على الإطلاق. أنصح بها بشدة!",
        "testimonial1-author": "- أحمد",
        "testimonial2": "طاقم عمل ودود وخدمة ممتازة. شكرًا لكم!",
        "testimonial2-author": "- سارة",
        "footer-contact": "اتصل بنا: 0123456789 | البريد الإلكتروني: info@myclinic.com",
    },
};

// تحديث النصوص بناءً على اللغة
function updateLanguage(lang) {
    const elements = document.querySelectorAll("[id]");
    elements.forEach((element) => {
        const key = element.id;
        if (translations[lang][key]) {
            element.textContent = translations[lang][key];
        }
    });

    // تحديث اتجاه الصفحة
    document.body.setAttribute("dir", lang === "ar" ? "rtl" : "ltr");

    // حفظ اللغة المفضلة
    localStorage.setItem("language", lang);
}

// تحميل اللغة المفضلة
function loadLanguagePreference() {
    const savedLang = localStorage.getItem("language") || "ar";
    document.getElementById("language-switcher").value = savedLang;
    updateLanguage(savedLang);
}

// حدث تغيير اللغة
document.getElementById("language-switcher").addEventListener("change", (event) => {
    const selectedLang = event.target.value;
    updateLanguage(selectedLang);
});

// تحميل اللغة عند فتح الصفحة
document.addEventListener("DOMContentLoaded", () => {
    loadLanguagePreference();
});