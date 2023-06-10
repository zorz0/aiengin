import React from "react";

const SubmittingButton = ({isSubmitting = false, onClick = () => {}, buttonString = 'Save', className = 'btn btn-primary w-100', ...props}) => {

    return (
        <button onClick={onClick} className={className} disabled={isSubmitting}>
            {isSubmitting && (<span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>)}
            {!isSubmitting && (<span>{buttonString}</span>)}
        </button>
    )
}

export default SubmittingButton;
