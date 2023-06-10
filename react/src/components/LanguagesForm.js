import React from "react";
import Form from 'react-bootstrap/Form';
import {store} from "../store/configureStore";

const LanguagesForm = () => {
    const options = [
        "English",
        "Spanish",
        "French",
        "German",
        "Italian",
        "Dutch",
        "Portuguese",
        "Russian",
        "Chinese (Mandarin)",
        "Japanese",
        "Korean",
        "Arabic",
        "Hindi",
        "Bengali",
        "Indonesian",
        "Turkish",
        "Thai",
        "Vietnamese",
        "Polish",
        "Ukrainian"
    ];

    const contentLanguage = store.getState().common.contentLanguage

    return (
        <Form.Select
            defaultValue={contentLanguage}
            name="language"
            onChange={e => {
                store.dispatch({type: 'CHANGE_CONTENT_LANGUAGE', language: e.target.value});
            }}
        >
            {options.map((e, i) => (
                <option key={i} value={e.toLowerCase()}>{e}</option>
            ))}
            <option value="Spanish">Spanish</option>
            <option value="French">French</option>
            <option value="German">German</option>
            <option value="Italian">Italian</option>
            <option value="Dutch">Dutch</option>
            <option value="Portuguese">Portuguese</option>
            <option value="Russian">Russian</option>
            <option value="Chinese (Mandarin)">Chinese (Mandarin)</option>
            <option value="Japanese">Japanese</option>
            <option value="Korean">Korean</option>
            <option value="Arabic">Arabic</option>
            <option value="Hindi">Hindi</option>
            <option value="Bengali">Bengali</option>
            <option value="Indonesian">Indonesian</option>
            <option value="Turkish">Turkish</option>
            <option value="Thai">Thai</option>
            <option value="Vietnamese">Vietnamese</option>
            <option value="Polish">Polish</option>
            <option value="Ukrainian">Ukrainian</option>
        </Form.Select>
    )
}

export default LanguagesForm;
