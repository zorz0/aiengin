import React, {useState, useEffect} from "react";
import {Icon} from "@iconify/react/dist/iconify";
import {useTranslation} from "react-i18next";

const CopyImageButton = ({ text }) => {
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
                const img = new Image();
                img.src = text;
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const context = canvas.getContext('2d');
                    context.drawImage(img, 0, 0);
                    const imageData = canvas.toDataURL('image/png');
                    navigator.clipboard.write([
                        new ClipboardItem({
                            'image/png': imageData
                        })
                    ]);
                }
                setIsCopied(true);
            }}
            className="btn border-0 text-secondary">
            {isCopied && (
                <>
                    <Icon icon="mdi:check-circle" className="text-success" />
                    <small className="ms-1">{t('Copied to clipboard')}</small>
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

export default CopyImageButton;
