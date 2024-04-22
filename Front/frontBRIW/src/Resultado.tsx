import React, { useCallback, useRef } from "react";



function ResultadoBusqueda({ titulo, snippet, logo, url }) {



    return (
      <div className=" border-secondary p-4 rounded-lg shadow-md flex items-center space-x-4 mr-12 z-0">
        {logo && (
            <div className="w-12 h-12 bg-neutral rounded-full flex justify-center">
              <img  className="rounded-full" src={logo} alt="page logo"/> 
            </div>
        )}
        <div className="flex-grow">
          <a href={url} className="font-medium text-accent hover:underline" target="_blank" rel="noopener noreferrer">
            {titulo}
          </a>
          <p className="text-gray-500">{snippet}</p>
          <a href={url} className="text-sm text-gray-400 hover:text-gray-600 hover:underline" target="_blank" rel="noopener noreferrer">
            {url}
          </a>
          <br/>
          <button className="btn" onClick={()=>document.getElementById('my_modal_4')!.showModal()}>open modal</button>
          <dialog id="my_modal_4" className="modal">
            <div className="modal-box w-11/12 max-w-5xl">
            <form method="dialog">
              {/* if there is a button in form, it will close the modal */}
              <button className="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
              <h3 className="font-bold text-lg">{url}</h3>
            </div>
          </dialog>
        </div>
      </div>
    );
  }
  
  export default ResultadoBusqueda;
  