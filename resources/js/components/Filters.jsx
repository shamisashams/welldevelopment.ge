import React, {useState} from "react";
import { SelectFilter } from "./Shared";
import { CiSearch } from "react-icons/ci";
import { Link, usePage } from '@inertiajs/inertia-react'

const Filters = ({appliedFilters}) => {
    const { filter, localizations } = usePage().props;



    let min, max;

    if(appliedFilters.hasOwnProperty('area')){
        min = appliedFilters['area'][0];
        max = appliedFilters['area'][1];
    } else {
        min = 0;
        max = '';
    }


    const [values, setValues] = useState(max ? [min,max] : []);

    function handleChangeMax(e) {
        const key = e.target.name;
        const value = e.target.value;

        if(value)
        setValues([document.getElementsByName('min')[0].value || 0,value]);
        else {
            setValues([]);
        }
    }

    function handleChangeMin(e) {
        const key = e.target.name;
        let value = e.target.value;
        value = value || 0;
        if(document.getElementsByName('max')[0].value)
        setValues([value,document.getElementsByName('max')[0].value]);
        else {
            setValues([]);
        }
    }


    function removeA(arr) {
        var what,
            a = arguments,
            L = a.length,
            ax;
        while (L > 1 && arr.length) {
            what = a[--L];
            while ((ax = arr.indexOf(what)) !== -1) {
                arr.splice(ax, 1);
            }
        }
        return arr;
    }

    const handleFilterClick = function (event, code, value) {
        //Inertia.visit('?brand=12');

        if (event.target.checked === true) {
            if (appliedFilters.hasOwnProperty(code)) {
                appliedFilters[code].push(value.toString());
            } else appliedFilters[code] = [value.toString()];
        } else {
            if (appliedFilters[code].length > 1)
                removeA(appliedFilters[code], value.toString());
            else delete appliedFilters[code];
        }

        console.log(appliedFilters)
    };



    const handleCommit = () => {

        console.log(appliedFilters)


        if(values.length > 0){
            appliedFilters['area'] = values
        } else delete appliedFilters['area'];


    }

    function clearArea(){
        delete appliedFilters['area'];
        setValues([]);
    }

    console.log(filter)
  const cities = [
    "თბილისი",
    "ბათუმი",
    "ქუთაისი",
    "გორი",
    "თელავი",
    "ბაკურიანი",
    "თბილისი",
    "ბათუმი",
    "ქუთაისი",
    "გორი",
    "თელავი",
    "ბაკურიანი",
  ];
  const status = [
    "ყველას მონიშვნა",
    "დაგეგმილი პროექტი",
    "მიმდინარე მშენებლობა",
    "დასკვნით ეტაპზე",
    "დასრულებული",
  ];
    let checked;
  return (
    <div className="flex lg:flex-row flex-col">
      <SelectFilter
        icon={
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="17.986"
            height="25.18"
            viewBox="0 0 17.986 25.18"
          >
            <path
              id="location-sharp"
              d="M15.743,2.25c-4.965,0-8.993,3.626-8.993,8.094,0,7.194,8.993,17.086,8.993,17.086s8.993-9.892,8.993-17.086C24.736,5.876,20.708,2.25,15.743,2.25Zm0,12.59a3.6,3.6,0,1,1,3.6-3.6A3.6,3.6,0,0,1,15.743,14.84Z"
              transform="translate(-6.75 -2.25)"
              fill="#0084d1"
            />
          </svg>
        }
        title={__('client.filter_city',localizations)}
        subtitle="თბილისი"
      >
        <div className="relative text-sm">
          <input className="pl-7" type="text" name="" id="" />
          <CiSearch className="absolute left-2 top-2 w-4 h-4" />
          <div className="max-h-48 overflow-y-scroll scrollbar">
            {filter.cities.map((item, index) => {

                if (appliedFilters.hasOwnProperty('city')) {
                    if (appliedFilters['city'].includes(item.id.toString())) {
                        checked = true;
                    } else checked = false;
                } else checked = false;
              return (
                <div
                  key={index}
                  className="flex justify-start items-center mb-3"
                >
                  <input onClick={(event) => {
                      handleFilterClick(event, 'city', item.id);
                  }} checked={checked} type="checkbox" id={`cityInput-${item.id}`} />
                  <label htmlFor={`cityInput-${item.id}`}>
                    <div></div>
                  </label>
                  <label htmlFor={`cityInput-${item.id}`}>{item.title}</label>
                </div>
              );
            })}
          </div>
        </div>
      </SelectFilter>
      <SelectFilter
        icon={
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="18.452"
            height="25.5"
            viewBox="0 0 18.452 25.5"
          >
            <g id="noun-building-106266" transform="translate(-167.65 -28)">
              <path
                id="Path_127"
                data-name="Path 127"
                d="M354.3,143.441v14.721l9.008-5.2V138.24Z"
                transform="translate(-177.206 -104.662)"
                fill="#0084d1"
              />
              <path
                id="Path_128"
                data-name="Path 128"
                d="M171.96,33.2l9.008,5.2,9.008-5.2L180.968,28Z"
                transform="translate(-4.092)"
                fill="#0084d1"
              />
              <path
                id="Path_129"
                data-name="Path 129"
                d="M479.94,339.026l1.76-1.016v2.807l-1.76,1.017Z"
                transform="translate(-296.49 -294.325)"
                fill="#0084d1"
              />
              <path
                id="Path_130"
                data-name="Path 130"
                d="M479.94,263.15l1.76-1.016v2.807l-1.76,1.017Z"
                transform="translate(-296.49 -222.288)"
                fill="#0084d1"
              />
              <path
                id="Path_131"
                data-name="Path 131"
                d="M479.94,187.336l1.76-1.016v2.806l-1.76,1.017Z"
                transform="translate(-296.49 -150.31)"
                fill="#0084d1"
              />
              <path
                id="Path_132"
                data-name="Path 132"
                d="M425.41,370.477l1.764-1.018v2.807l-1.764,1.018Z"
                transform="translate(-244.719 -324.183)"
                fill="#0084d1"
              />
              <path
                id="Path_133"
                data-name="Path 133"
                d="M425.41,294.6l1.764-1.019v2.808L425.41,297.4Z"
                transform="translate(-244.719 -252.14)"
                fill="#0084d1"
              />
              <path
                id="Path_134"
                data-name="Path 134"
                d="M425.41,218.783l1.764-1.018v2.805l-1.764,1.019Z"
                transform="translate(-244.719 -180.164)"
                fill="#0084d1"
              />
              <path
                id="Path_135"
                data-name="Path 135"
                d="M370.79,402l1.765-1.019v2.807L370.79,404.8Z"
                transform="translate(-192.862 -354.108)"
                fill="#0084d1"
              />
              <path
                id="Path_136"
                data-name="Path 136"
                d="M370.79,326.129l1.765-1.018v2.807l-1.765,1.019Z"
                transform="translate(-192.862 -282.079)"
                fill="#0084d1"
              />
              <path
                id="Path_137"
                data-name="Path 137"
                d="M370.79,250.308l1.765-1.019v2.805l-1.765,1.019Z"
                transform="translate(-192.862 -210.093)"
                fill="#0084d1"
              />
              <path
                id="Path_138"
                data-name="Path 138"
                d="M167.65,138.24v14.721l3.646,2.107v-5.13l1.764,1.018v5.129l3.6,2.077V143.441Zm2.652,13.931-1.76-1.017v-2.807l1.76,1.018Zm0-3.838-1.76-1.017v-2.807l1.76,1.016Zm0-3.838-1.76-1.016v-2.806l1.76,1.016Zm2.759,5.43-1.764-1.018V146.1l1.764,1.018Zm0-3.838-1.764-1.018v-2.806l1.764,1.018Zm2.764,9.272-1.765-1.021v-2.805l1.765,1.019Zm0-3.839-1.765-1.019v-2.807l1.765,1.019Zm0-3.838-1.765-1.019v-2.806l1.765,1.019Z"
                transform="translate(0 -104.662)"
                fill="#0084d1"
              />
              <path
                id="Path_139"
                data-name="Path 139"
                d="M249.221,383.547l-.893-.516v4.19l.893-.516Z"
                transform="translate(-76.596 -337.068)"
                fill="#0084d1"
              />
            </g>
          </svg>
        }
        title={__('client.filter_status',localizations)}
        subtitle="დასრულებული"
      >
        <div className="max-h-48 overflow-y-scroll scrollbar py-2">
          {filter.attributes.status.options.map((item, index) => {
              if (appliedFilters.hasOwnProperty('status')) {
                  if (appliedFilters['status'].includes(item.id.toString())) {
                      checked = true;
                  } else checked = false;
              } else checked = false;
            return (
              <div key={index} className="flex justify-start items-center mb-3">
                <input onClick={(event) => {
                    handleFilterClick(event, 'status', item.id);
                }} checked={checked} type="checkbox" name="" id={`statusInput-${item.id}`} />
                <label htmlFor={`statusInput-${item.id}`}>
                  <div></div>
                </label>
                <label htmlFor={`statusInput-${item.id}`}>{item.label}</label>
              </div>
            );
          })}
        </div>
      </SelectFilter>
      <SelectFilter
        icon={
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="25.504"
            height="25.5"
            viewBox="0 0 25.504 25.5"
          >
            <g id="noun-paint-5222063" transform="translate(-97.963 -28)">
              <path
                id="Path_140"
                data-name="Path 140"
                d="M118.092,30.172A2.842,2.842,0,0,0,115.34,28H100.8a2.842,2.842,0,0,0-2.833,2.833v.945a2.842,2.842,0,0,0,2.833,2.833H115.34a2.842,2.842,0,0,0,2.752-2.172,3.023,3.023,0,1,1-.009,6.044h-8.311a3.971,3.971,0,0,0-3.967,3.967V43.8a1.128,1.128,0,0,0,.017.169,2.842,2.842,0,0,0-1.882,2.665v4.038a2.842,2.842,0,0,0,2.833,2.833h.331a2.842,2.842,0,0,0,2.833-2.833V46.629a2.842,2.842,0,0,0-1.882-2.665,1.128,1.128,0,0,0,.017-.169V42.45a1.7,1.7,0,0,1,1.7-1.7h8.311a5.391,5.391,0,0,0,5.372-5.035,1.147,1.147,0,0,0,.011-.159v-.189a1.147,1.147,0,0,0-.011-.159,5.391,5.391,0,0,0-5.363-5.035Z"
                fill="#0084d1"
              />
            </g>
          </svg>
        }
        title={__('client.filter_condition',localizations)}
        subtitle="მწვანე კარკასი"
      >
        <div className="max-h-48 overflow-y-scroll scrollbar py-2">
          {filter.attributes.condition.options.map((item, index) => {
              if (appliedFilters.hasOwnProperty('condition')) {
                  if (appliedFilters['condition'].includes(item.id.toString())) {
                      checked = true;
                  } else checked = false;
              } else checked = false;
            return (
              <div key={index} className="flex justify-start items-center mb-3">
                <input onClick={(event) => {
                    handleFilterClick(event, 'condition', item.id);
                }} checked={checked} type="checkbox" name="" id={`conditionInput-${item.id}`} />
                <label htmlFor={`conditionInput-${item.id}`}>
                  <div></div>
                </label>
                <label htmlFor={`conditionInput-${item.id}`}>{item.label}</label>
              </div>
            );
          })}
        </div>
      </SelectFilter>
      <SelectFilter
        icon={
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="25.18"
            height="25.18"
            viewBox="0 0 25.18 25.18"
          >
            <path
              id="bxs-area"
              d="M4.5,26.882a2.8,2.8,0,0,0,2.8,2.8H26.882a2.8,2.8,0,0,0,2.8-2.8V7.3a2.8,2.8,0,0,0-2.8-2.8H7.3A2.8,2.8,0,0,0,4.5,7.3ZM17.09,8.7h8.393V17.09h-2.8v-5.6h-5.6ZM8.7,17.09h2.8v5.6h5.6v2.8H8.7Z"
              transform="translate(-4.5 -4.5)"
              fill="#0084d1"
            />
          </svg>
        }
        title={__('client.filter_area',localizations)}
        subtitle="50 - 250 კვ. მ"
      >
        <div className="py-2">
          <div className="flex">
            <div className="mr-3">
              <p>{__('client.filter_min',localizations)}</p>
              <input name={'min'} className="mt-2" type="text" placeholder="40 კვ. მ" onChange={handleChangeMin} value={values.length > 0 ? values[0] : ''} />
            </div>
            <div>
              <p>{__('client.filter_max',localizations)}</p>
              <input name={'max'} className="mt-2" type="text" placeholder="350 კვ. მ" onChange={handleChangeMax} value={values.length > 0 ? values[1] : ''} />
            </div>
          </div>
          <div className="flex justify-between">
            <button onClick={clearArea} className="py-3 ">{__('client.filter_erase',localizations)}</button>
            <button onClick={handleCommit} className="px-4 py-3 bg-custom-blue rounded-lg text-white">
                {__('client.filter_select',localizations)}
            </button>
          </div>
        </div>
      </SelectFilter>
    </div>
  );
};

export default Filters;