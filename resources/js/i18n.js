import { createI18n } from 'vue-i18n'
import en from '../lang/en.json'
import ar from '../lang/ar.json'

function loadLocaleMessages() {
    const locales = [{ en: en }, { ar: ar }]
    const messages = {}
    locales.forEach(lang => {
        const key = Object.keys(lang)
        messages[key] = lang[key]
    })
    return messages
}

export default createI18n({
    locale: localStorage.getItem('lang'),
    fallbackLocale: localStorage.getItem('lang'),
    messages: loadLocaleMessages()
})
