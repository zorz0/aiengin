import i18n from "i18next";
import { initReactI18next } from "react-i18next";

i18n.use(initReactI18next).init({
    fallbackLng: 'en',
    compatibilityJSON: 'v3',
    initImmediate: false,
    lng: 'en',
    resources: localesResource,
    react: {
        useSuspense: false
    },
    interpolation: {
        escapeValue: false
    }
});


export default i18n;
