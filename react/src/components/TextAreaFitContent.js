import React, {useRef} from "react";
import Form from "react-bootstrap/Form";

const TextAreaFitContent = ({ value, setValue, placeholder, ...props }) => {
    const textAreaRef = useRef(null);
    const handleInput = (event) => {
        if (textAreaRef.current.scrollHeight > textAreaRef.current.clientHeight) {
            textAreaRef.current.style.height = "";
            //textAreaRef.current.style.height = `${event.target.scrollHeight}px`;
        }
    };

    return (
        <Form.Control
            ref={textAreaRef}
            onInput={handleInput}
            as="textarea"
            required
            placeholder={placeholder}
            value={value}
            onChange={setValue}
            {...props}
        />
    )
}

export default TextAreaFitContent;
