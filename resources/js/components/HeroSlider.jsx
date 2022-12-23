import React, { useRef } from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/navigation";
import { Navigation } from "swiper";
import { Link, usePage } from "@inertiajs/inertia-react";
import { HiArrowRight, HiArrowLeft } from "react-icons/hi";
import Filters from "./Filters";
import { CiSearch } from "react-icons/ci";
import { Inertia } from "@inertiajs/inertia";

const HeroSlider = () => {
    const { sliders, localizations } = usePage().props;

    //console.log(sliders)
    const prevRef = useRef(null);
    const nextRef = useRef(null);

    let appliedFilters = {};
    let urlParams = new URLSearchParams(window.location.search);

    urlParams.forEach((value, index) => {
        appliedFilters[index] = value.split(",");
    });

    function search() {
        let params = [];

        for (let key in appliedFilters) {
            params.push(key + "=" + appliedFilters[key].join(","));
        }

        Inertia.visit(route("client.apartment.index") + "?" + params.join("&"));
    }

    const renderHTML = (rawHTML) =>
        React.createElement("p", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

    return (
        <div className="relative">
            <Swiper
                navigation={true}
                modules={[Navigation]}
                className="heroSlider"
                onInit={(swiper) => {
                    swiper.params.navigation.prevEl = prevRef.current;
                    swiper.params.navigation.nextEl = nextRef.current;
                    swiper.navigation.init();
                    swiper.navigation.update();
                }}
            >
                {sliders.map((item, index) => {
                    let flats = 0;

                    if (item.project) {
                        if (item.project.apartments) {
                            item.project.apartments.map((apartment, n) => {
                                flats += apartment.floors.length;
                            });
                        }
                    }

                    return (
                        <SwiperSlide key={index} className="!h-auto">
                            <div className="xl:pt-20 pt-14 pb-10">
                                <img
                                    className="absolute left-0 top-0 w-full h-full object-cover -z-10"
                                    src={item.file ? item.file.full_url : null}
                                    alt=""
                                />
                                <div className="wrapper">
                                    <div className="max-w-2xl">
                                        <div className="xl:text-5xl sm:text-3xl text-xl bold xl:mb-8 mb-3 text-white">
                                            {item.title}
                                        </div>
                                        <div className="text-white">
                                        {renderHTML(item.description)}
                                        </div>
                                        <Link
                                            className="group flex items-center justify-center bg-white rounded-md w-fit p-3 bold sm:mt-8 mt-4"
                                            href={item.youtube_url}
                                        >
                                            <span className="group-hover:max-w-sm max-w-0 overflow-hidden whitespace-nowrap group-hover:pr-2 transition-all duration-300">
                                                {__("client.view_more", localizations)}
                                            </span>
                                            <HiArrowRight className="w-6 h-6" />
                                        </Link>
                                    </div>
                                    {item.project ? (
                                        <div className="lg:flex hidden justify-start xl:mt-60 mt-10 text-white">
                                            <div className="flex mr-10">
                                                <div className="text-right opacity-50 pr-3 border-r border-slate-500">
                                                    {renderHTML(
                                                        __("client.slide_recreational_space", localizations).newLineToBr()
                                                    )}
                                                </div>
                                                <span className="bold text-3xl pl-3 align-middle">
                                                    {
                                                        item.project
                                                            .recreational_space
                                                    }{" "}
                                                    {__("client.m_2", localizations)}
                                                </span>
                                            </div>
                                            <div className="flex mr-10">
                                                <div className="text-right opacity-50 pr-3 border-r  border-slate-500">
                                                    {renderHTML(
                                                        __("client.slide_parking", localizations).newLineToBr()
                                                    )}
                                                </div>
                                                <span className="bold text-3xl pl-3 align-middle">
                                                    {item.project.parking}
                                                </span>
                                            </div>
                                            <div className="flex mr-10">
                                                <div className="text-right opacity-50 pr-3 border-r  border-slate-500">
                                                    {renderHTML(
                                                        __("client.slide_available_flats", localizations).newLineToBr()
                                                    )}
                                                </div>
                                                <span className="bold text-3xl pl-3 align-middle">
                                                    {flats}
                                                </span>
                                            </div>
                                        </div>
                                    ) : null}
                                </div>
                            </div>
                        </SwiperSlide>
                    );
                })}
                <div className="absolute left-1/2 xl:bottom-10 xl:top-auto bottom-auto top-3 -translate-x-1/2 wrapper h-fit flex justify-end items-center z-20">
                    <button
                        ref={prevRef}
                        className="lg:w-12 lg:h-12 w-8 h-8 flex items-center justify-center bg-white rounded-md"
                    >
                        <HiArrowLeft className="w-6 h-6" />
                    </button>
                    <button
                        ref={nextRef}
                        className="lg:w-12 lg:h-12 w-8 h-8 flex items-center justify-center bg-white rounded-md  xl:ml-6 ml-4"
                    >
                        <HiArrowRight className="w-6 h-6" />
                    </button>
                </div>
            </Swiper>
            <div className="xl:absolute xl:bottom-40 xl:left-1/2 xl:-translate-x-1/2 flex xl:flex-row items-start h-fit xl:w-fit w-auto flex-col wrapper z-20 max-w-7xl bg-white xl:py-6 py-12 xl:px-2 rounded-3xl xl:shadow-lg  ">
                <Filters appliedFilters={appliedFilters} />
                <button
                    onClick={search}
                    className="xl:w-14 w-full h-14 flex items-center justify-center bg-custom-blue text-white rounded-md text-3xl md:ml-5 shrink-0"
                >
                    <CiSearch />
                </button>
            </div>
        </div>
    );
};

export default HeroSlider;
