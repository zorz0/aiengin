import { useState, useEffect } from 'react';

const TypingAnimation = ({ text, delay = 50 }) => {
    const [displayText, setDisplayText] = useState('');

    useEffect(() => {
        let currentText = '';
        let i = 0;

        const intervalId = setInterval(() => {
            if (i < text.length) {
                currentText += text.charAt(i);
                setDisplayText(currentText);
                i++;
            } else {
                clearInterval(intervalId);
            }
        }, delay);

        return () => clearInterval(intervalId);
    }, [text, delay]);

    return <div dangerouslySetInnerHTML={{ __html: displayText }} />;
};

export default TypingAnimation;
