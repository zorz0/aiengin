import React, {useState, useEffect} from "react";

const UserAvatar = ({ url, width = 40, name = '', ...props }) => {

    return url ? (
        <img className="rounded" src={url} alt={name} width={width} height={width}/>
    ) : (
        <div
            style={{
                width: width + 'px',
                height: width + 'px',
            }}
            className="rounded bg-primary d-flex justify-content-center align-items-center"
        >
            <span className="fs-5 text-white">{name.charAt(0)}</span>
        </div>
    )
}

export default UserAvatar;
