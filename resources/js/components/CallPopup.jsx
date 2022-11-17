import React from "react";
import { CallButton } from "./Shared";
//import Icon from "../assets/images/icons/17.png";
import { useState } from "react";
import { IoClose } from "react-icons/io5";

const CallPopup = ({ show, hide }) => {
  const [sent, setSent] = useState(false);

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
        <div className="bold mb-5">მოითხოვე ზარი</div>
        <form action="">
          <input className="mb-3" type="text" placeholder="სახელი" />
          <input className="mb-3" type="text" placeholder="ტელეფონის ნომერი" />
          <textarea className="mb-0" placeholder="კომენტარი"></textarea>
        </form>
        <CallButton onClick={() => setSent(true)} />

        <div
          className={`absolute left-0 top-0 w-full h-full flex flex-col items-center justify-center text-center p-20 bg-white rounded-xl transition-all duration-300 ${
            sent ? "opacity-100 visible " : "opacity-0 invisible"
          }`}
        >
          <img className="mb-5" src="/client/assets/images/icons/17.png" alt="" />
          <p>თქვენი მოთხოვნა მიღებულია, ოპერატორი მალე დაგიკავშირდებათ</p>
        </div>
      </div>
    </div>
  );
};

export default CallPopup;
