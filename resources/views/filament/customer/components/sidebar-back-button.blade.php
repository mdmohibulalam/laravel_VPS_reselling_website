<div class="fi-customer-sidebar-back-btn" style="padding: 6px 12px 14px 12px; box-sizing: border-box;">
    {{-- Expanded State (Sidebar Open) --}}
    <div x-show="$store.sidebar.isOpen" style="transition: all 0.2s ease;">
        <a href="{{ url('/') }}" 
           style="
               display: flex; 
               align-items: center; 
               justify-content: space-between; 
               gap: 10px; 
               width: 100%; 
               padding: 9px 12px; 
               border-radius: 12px; 
               background: linear-gradient(135deg, #673DE6 0%, #4F27CB 100%); 
               color: #ffffff; 
               text-decoration: none; 
               box-shadow: 0 4px 14px rgba(103, 61, 230, 0.35); 
               border: 1px solid rgba(255, 255, 255, 0.25); 
               box-sizing: border-box;
               cursor: pointer;
               transition: all 0.2s ease;
           "
           onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 18px rgba(103, 61, 230, 0.5)';"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(103, 61, 230, 0.35)';"
        >
            {{-- Left Icon & Text --}}
            <div style="display: flex; align-items: center; gap: 9px; min-width: 0;">
                <div style="
                    display: flex; 
                    align-items: center; 
                    justify-content: center; 
                    width: 28px; 
                    height: 28px; 
                    border-radius: 8px; 
                    background: rgba(255, 255, 255, 0.2); 
                    flex-shrink: 0;
                ">
                    <svg style="width: 15px; height: 15px; min-width: 15px; min-height: 15px; max-width: 15px; max-height: 15px; color: #ffffff; display: block;" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </div>
                <div style="display: flex; flex-direction: column; text-align: left; min-width: 0;">
                    <span style="font-family: inherit; font-size: 12px; font-weight: 700; line-height: 1.2; color: #ffffff; letter-spacing: -0.01em; white-space: nowrap;">
                        Back to Website
                    </span>
                    <span style="font-family: inherit; font-size: 10px; font-weight: 500; color: #DDD6FE; line-height: 1.2; margin-top: 1px; white-space: nowrap;">
                        Exit Customer Portal
                    </span>
                </div>
            </div>

            {{-- Right Public Badge --}}
            <div style="flex-shrink: 0;">
                <span style="
                    display: inline-flex; 
                    align-items: center; 
                    gap: 3px; 
                    padding: 2px 7px; 
                    border-radius: 6px; 
                    font-family: inherit; 
                    font-size: 10px; 
                    font-weight: 800; 
                    background: #ffffff; 
                    color: #673DE6; 
                    letter-spacing: 0.04em; 
                    text-transform: uppercase;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
                    white-space: nowrap;
                ">
                    <span>Public</span>
                    <svg style="width: 10px; height: 10px; min-width: 10px; min-height: 10px; color: #673DE6; display: inline-block;" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </span>
            </div>
        </a>
    </div>

    {{-- Collapsed State (Sidebar Closed) --}}
    <div x-show="! $store.sidebar.isOpen" x-cloak style="display: flex; justify-content: center; transition: all 0.2s ease;">
        <a href="{{ url('/') }}" 
           title="Back to Website"
           style="
               display: flex; 
               align-items: center; 
               justify-content: center; 
               width: 36px; 
               height: 36px; 
               border-radius: 10px; 
               background: linear-gradient(135deg, #673DE6 0%, #4F27CB 100%); 
               color: #ffffff; 
               text-decoration: none; 
               box-shadow: 0 4px 12px rgba(103, 61, 230, 0.35); 
               border: 1px solid rgba(255, 255, 255, 0.25); 
               cursor: pointer;
               transition: all 0.2s ease;
           "
           onmouseover="this.style.transform='scale(1.05)';"
           onmouseout="this.style.transform='scale(1)';"
        >
            <svg style="width: 18px; height: 18px; min-width: 18px; min-height: 18px; max-width: 18px; max-height: 18px; color: #ffffff; display: block;" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </a>
    </div>
</div>
