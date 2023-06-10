import React, {useEffect, useState} from "react";
import {Provider, useSelector} from "react-redux";
import { PersistGate } from 'redux-persist/lib/integration/react';
import {store, persistor} from './store/configureStore';
import AppNavigator from "./navigations/AppNavigator";
import { I18nextProvider } from 'react-i18next';
import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';
import {addWindowClass, removeWindowClass} from "./helpers/Utils";

i18n.use(initReactI18next).init({
    fallbackLng: 'en',
    compatibilityJSON: 'v3',
    initImmediate: false,
    lng: store.getState().display.lang,
    react: {
        useSuspense: false,
    },
    interpolation: {
        escapeValue: false,
    },
});

function App() {
    const lang = store.getState().display.language;
    useEffect(() => {
        fetch(`/assets/lang/en.json`)
            .then((response) => response.json())
            .then((data) => {
                i18n.addResourceBundle('en', 'translation', data);
                i18n.changeLanguage('en');
            }).then(() => {
                if(lang !== 'en') {
                    fetch(`/assets/lang/${lang}.json`)
                        .then((response) => response.json())
                        .then((data) => {
                            i18n.addResourceBundle(lang, 'translation', data);
                        }).then(() => {
                        i18n.changeLanguage(lang);
                    });
                }
        });
    }, []);

    useEffect(() => {
        setTimeout(async () => {
            //Load library after render the app
            const { default: ClassicEditor } = await import('@ckeditor/ckeditor5-build-classic');

            const html2canvas = document.createElement('script');
            html2canvas.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
            html2canvas.async = true;
            document.head.appendChild(html2canvas);

            const dompurify = document.createElement('script');
            dompurify.src = 'https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.0/purify.min.js';
            dompurify.async = true;
            document.head.appendChild(dompurify);

            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
            script.async = true;
            document.head.appendChild(script);

        }, 5000);
    }, [])

    return (
        <Provider store={store}>
            <PersistGate
                loading={<div/>}
                persistor={persistor}>
                <I18nextProvider i18n={i18n}>
                    <AppNavigator />
                </I18nextProvider>
            </PersistGate>
        </Provider>
    );
}

export default App;
