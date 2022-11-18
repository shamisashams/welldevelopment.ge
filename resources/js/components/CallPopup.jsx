import React from "react";
import { CallButton } from "./Shared";
//import Icon from "../assets/images/icons/17.png";
import { useState } from "react";
import { IoClose } from "react-icons/io5";
import axios from "axios";
import {usePage } from '@inertiajs/inertia-react';

const CallPopup = ({ show, hide }) => {
  const [sent, setSent] = useState(false);

    const {localizations} = usePage().props;

    const [values, setValues] = useState({
        name: "",
        phone: "",
        comment: "",
    });

    function post(){
        axios.post(route('client.call_request'), values)
            .then(function (response) {
                console.log(response);
                setSent(true)
            })
            .catch(function (error) {
                console.log(error.response);
                alert(error.response.data.message)
            });
    }

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setValues((values) => ({
            ...values,
            [key]: value,
        }));
    }

  return (
    <div
      className={`fixed left-0 top-0 w-screen h-screen z-50 bg-black/[0.8] flex items-center justify-center p-10 transition-all duration-500 ${
        show ? "opacity-100 visible" : "opacity-0 invisible"
      }`}
    >
      <div className="bg-white rounded-xl py-10 px-20 text-center relative max-w-lg">
        <button
          onClick={hide}
          className="absolute -top-8 -right-8 text-white text-4xl"
        >
          <IoClose />
        </button>
        <div className="bold mb-5">{__('client.call_request',localizations)}</div>
        <form action="">
          <input onChange={handleChange} name="name" className="mb-3" type="text" placeholder={__('client.form_name',localizations)} />
          <input onChange={handleChange} name="phone" className="mb-3" type="text" placeholder={__('client.form_phone',localizations)} />
          <textarea onChange={handleChange} name="comment" className="mb-0" placeholder={__('client.form_comment',localizations)}></textarea>
        </form>
        <CallButton onClick={() => {
            post()

        }} />

        <div
          className={`absolute left-0 top-0 w-full h-full flex flex-col items-center justify-center text-center p-20 bg-white rounded-xl transition-all duration-300 ${
            sent ? "opacity-100 visible " : "opacity-0 invisible"
          }`}
        >
          <img className="mb-5" src="/client/assets/images/icons/17.png" alt="" />
          <p>{__('client.call_request_success',localizations)}</p>
        </div>
      </div>
    </div>
  );
};

export default CallPopup;
