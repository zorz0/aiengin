import React, {useState, useEffect} from "react";
import {copyText} from "../helpers/Utils";
import {Icon} from "@iconify/react/dist/iconify";
import {useTranslation} from "react-i18next";

const CopyButton = ({ text }) => {
    const { t } = useTranslation();
    const [isCopied, setIsCopied] = useState(false);

    useEffect(() => {
        if(isCopied) {
            setTimeout(() => setIsCopied(false), 5000)
        }
    }, [isCopied])

    return (
        <button
            onClick={() => {
                copyText(text.replace(/<\/?[^>]+>/g, '').replace(/<\/?p>/g, '\n'));
                setIsCopied(true);
            }}
            className="btn border-0 text-secondary">
            {isCopied && (
                <>
                    <Icon icon="mdi:check-circle" className="text-success" />
                    <small className="ms-1">{t('Copied')}</small>
                </>
            )}
            {!isCopied && (
                <>
                    <Icon icon="mdi:content-copy" />
                    <small className="ms-1">{t('Copy')}</small>
                </>
            )}
        </button>
    )
}

export default CopyButton;
