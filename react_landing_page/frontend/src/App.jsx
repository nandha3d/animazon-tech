import React, { useState, useEffect, useRef } from 'react';
import { motion, useScroll, useTransform, AnimatePresence } from 'framer-motion';
import { 
  Sun, Moon, Wallet, Search, ArrowRight, Zap, 
  Users, TrendingUp, ShieldCheck, Instagram, 
  Twitter, Github, Menu, X 
} from 'lucide-react';

const App = () => {
  const [theme, setTheme] = useState('dark');
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const scrollRef = useRef(null);

  useEffect(() => {
    document.documentElement.setAttribute('data-theme', theme);
  }, [theme]);

  const toggleTheme = () => {
    setTheme(prev => prev === 'dark' ? 'light' : 'dark');
  };

  const navLinks = [
    { name: 'Marketplace', href: '#market' },
    { name: 'Drops', href: '#drops' },
    { name: 'Community', href: '#community' },
    { name: 'Artists', href: '#artists' },
  ];

  const stats = [
    { icon: <TrendingUp className="text-gradient" />, title: '$2M+', label: 'Trading Volume' },
    { icon: <Users className="text-gradient" />, title: '50K+', label: 'Active Collectors' },
    { icon: <ShieldCheck className="text-gradient" />, title: '15K+', label: 'Verified Creators' },
  ];

  const nfts = [
    { title: "Neon Cybercat #204", price: "0.85 ETH", img: "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=800" },
    { title: "Astral Shiba #911", price: "1.25 ETH", img: "https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?auto=format&fit=crop&q=80&w=800" },
    { title: "Royal Persian #042", price: "0.65 ETH", img: "https://images.unsplash.com/photo-1643101809754-43a91784611a?auto=format&fit=crop&q=80&w=800" },
    { title: "Deep Sea Husky #333", price: "2.10 ETH", img: "https://images.unsplash.com/photo-1550684848-fac1c5b4e853?auto=format&fit=crop&q=80&w=800" },
    { title: "Quantum Raptor #771", price: "1.45 ETH", img: "https://images.unsplash.com/photo-1634986666676-ec8fd927c23d?auto=format&fit=crop&q=80&w=800" },
  ];

  return (
    <div className="min-h-screen">
      {/* Navigation */}
      <nav className="glass fixed top-0 w-full z-50 py-4">
        <div className="container flex items-center justify-between" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
          <div className="flex items-center gap-2" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
            <div className="bg-gradient w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-xl" style={{ borderRadius: '10px', width: '40px', height: '40px', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
              A
            </div>
            <span className="text-2xl font-black tracking-tighter" style={{ fontSize: '1.5rem', fontWeight: 900 }}>ANIMAZON</span>
          </div>

          {/* Desktop Nav */}
          <div className="hidden md:flex items-center gap-8" style={{ display: 'flex', gap: '2rem', alignItems: 'center' }}>
            {navLinks.map((link) => (
              <a key={link.name} href={link.href} className="text-sm font-semibold hover:text-gradient transition-all">
                {link.name}
              </a>
            ))}
            <div style={{ width: '1px', height: '24px', background: 'var(--border)' }}></div>
            <button onClick={toggleTheme} className="p-2 rounded-full hover:bg-offset transition-all" style={{ padding: '8px' }}>
              {theme === 'dark' ? <Sun size={20} /> : <Moon size={20} />}
            </button>
            <button className="btn btn-primary">
              <Wallet size={18} />
              <span>Connect Wallet</span>
            </button>
          </div>
        </div>
      </nav>

      {/* Hero Section */}
      <section className="section-padding overflow-hidden" style={{ paddingTop: '150px' }}>
        <div className="container relative">
          <motion.div 
            initial={{ opacity: 0, y: 50 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            className="text-center"
          >
            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full glass mb-8" style={{ border: '1.5px solid var(--primary)', padding: '6px 16px', borderRadius: '50px', marginBottom: '2rem', display: 'inline-flex', alignItems: 'center', gap: '8px' }}>
              <Zap size={14} className="text-primary" style={{ color: 'var(--primary)' }} />
              <span className="text-xs font-bold tracking-widest uppercase" style={{ fontSize: '0.75rem', fontWeight: 800 }}>AI Powered Pet Avatars</span>
            </div>
            
            <h1 className="text-6xl md:text-8xl mb-8" style={{ fontSize: 'clamp(3rem, 10vw, 6rem)', marginBottom: '1.5rem' }}>
              Create & Trade <br />
              <span className="text-gradient">Custom Pet NFTs</span>
            </h1>
            
            <p className="max-w-2xl mx-auto text-muted text-lg mb-12" style={{ maxWidth: '42rem', margin: '0 auto 3rem', color: 'var(--text-muted)', fontSize: '1.125rem' }}>
              Animazon is a platform for creators and collectors to create and trade custom pet-themed NFT avatars. Each NFT is unique, generated with AI technology, and can be used in top web3 games and metaverse platforms.
            </p>
            
            <div className="flex flex-col md:row items-center justify-center gap-4" style={{ display: 'flex', justifyContent: 'center', gap: '1rem' }}>
              <button className="btn btn-primary px-10 py-4 text-lg">
                Explore Collection
                <ArrowRight size={20} />
              </button>
              <button className="btn btn-secondary px-10 py-4 text-lg">
                View Roadmap
              </button>
            </div>
          </motion.div>

          {/* Decorative Elements */}
          <div className="absolute -top-20 -left-40 w-80 h-80 bg-primary/20 blur-[120px] rounded-full -z-10" style={{ position: 'absolute', top: '-100px', left: '-150px', width: '320px', height: '320px', background: 'rgba(240, 148, 51, 0.1)', filter: 'blur(120px)', borderRadius: '50%', zIndex: -1 }}></div>
          <div className="absolute top-40 -right-40 w-96 h-96 bg-secondary/20 blur-[150px] rounded-full -z-10" style={{ position: 'absolute', top: '160px', right: '-150px', width: '400px', height: '400px', background: 'rgba(88, 81, 219, 0.1)', filter: 'blur(150px)', borderRadius: '50%', zIndex: -1 }}></div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="section-padding">
        <div className="container">
          <div className="glass rounded-[2rem] p-12 grid grid-cols-1 md:grid-cols-3 gap-12" style={{ borderRadius: '2rem', padding: '3rem', display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '3rem' }}>
            {stats.map((stat, i) => (
              <motion.div 
                key={i}
                initial={{ opacity: 0, x: -20 }}
                whileInView={{ opacity: 1, x: 0 }}
                transition={{ delay: i * 0.2 }}
                className="flex flex-col items-center text-center gap-4"
                style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', gap: '1rem' }}
              >
                <div className="p-4 rounded-2xl bg-offset" style={{ padding: '1rem', borderRadius: '1rem', background: 'var(--bg-offset)' }}>
                  {React.cloneElement(stat.icon, { size: 32 })}
                </div>
                <div>
                  <div className="text-4xl font-bold mb-1" style={{ fontSize: '2.5rem', fontWeight: 800 }}>{stat.title}</div>
                  <div className="text-muted font-medium" style={{ color: 'var(--text-muted)', fontWeight: 500 }}>{stat.label}</div>
                </div>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Featured Showcase */}
      <section id="drops" className="section-padding">
        <div className="container">
          <div className="flex items-end justify-between mb-16" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end', marginBottom: '4rem' }}>
            <div>
              <h2 className="text-5xl mb-4" style={{ fontSize: '3rem', marginBottom: '1rem' }}>Featured <span className="text-gradient">Collections</span></h2>
              <p className="text-muted" style={{ color: 'var(--text-muted)' }}>Curated selection of our most anticipated pet avatars.</p>
            </div>
            <button className="flex items-center gap-2 font-bold hover:gap-4 transition-all" style={{ display: 'flex', alignItems: 'center', gap: '8px', fontWeight: 700 }}>
              <span>View All</span>
              <ArrowRight size={20} className="text-primary" />
            </button>
          </div>
        </div>

        <div className="flex gap-8 px-8 overflow-x-auto no-scrollbar pb-10" style={{ display: 'flex', gap: '2rem', paddingLeft: '2rem', paddingRight: '2rem', overflowX: 'auto', paddingBottom: '2.5rem' }}>
          {nfts.map((nft, i) => (
            <motion.div 
              key={i}
              whileHover={{ y: -10 }}
              className="glass min-w-[320px] rounded-[2rem] overflow-hidden group border-0"
              style={{ minWidth: '320px', borderRadius: '2rem', overflow: 'hidden', position: 'relative' }}
            >
              <div className="aspect-[4/5] overflow-hidden" style={{ aspectRatio: '4/5', overflow: 'hidden' }}>
                <img src={nft.img} alt={nft.title} className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
              </div>
              <div className="p-6" style={{ padding: '1.5rem' }}>
                <div className="flex justify-between items-center mb-4" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1rem' }}>
                  <h3 className="text-xl" style={{ fontSize: '1.25rem' }}>{nft.title}</h3>
                  <div className="bg-offset px-3 py-1 rounded-lg text-xs font-bold" style={{ background: 'var(--bg-offset)', padding: '4px 12px', borderRadius: '8px', fontSize: '0.75rem', fontWeight: 800 }}>
                    Rare
                  </div>
                </div>
                <div className="flex justify-between items-end" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                  <div>
                    <p className="text-xs text-muted mb-1" style={{ fontSize: '0.75rem', color: 'var(--text-muted)' }}>Current Bid</p>
                    <p className="font-bold text-lg" style={{ fontWeight: 700, fontSize: '1.125rem' }}>{nft.price}</p>
                  </div>
                  <button className="p-3 rounded-xl bg-gradient text-white shadow-lg" style={{ padding: '0.75rem', borderRadius: '0.75rem' }}>
                    <Search size={18} />
                  </button>
                </div>
              </div>
            </motion.div>
          ))}
        </div>
      </section>

      {/* Footer */}
      <footer className="pt-20 pb-10 border-t border-border" style={{ paddingTop: '5rem', paddingBottom: '2.5rem', borderTop: '1.5px solid var(--border)' }}>
        <div className="container">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20" style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '3rem', marginBottom: '5rem' }}>
            <div className="col-span-1 md:col-span-1" style={{ gridColumn: 'span 1' }}>
              <div className="flex items-center gap-2 mb-6" style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '1.5rem' }}>
                <div className="bg-gradient w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-xl">A</div>
                <span className="text-2xl font-black tracking-tighter">ANIMAZON</span>
              </div>
              <p className="text-muted leading-relaxed" style={{ color: 'var(--text-muted)', lineHeight: 1.625 }}>
                The premier platform for creating and trading unique pet NFTs. Step into the future of digital collectibles.
              </p>
            </div>
            
            <div>
              <h4 className="text-lg mb-6" style={{ marginBottom: '1.5rem' }}>Platform</h4>
              <ul className="flex flex-col gap-4 text-muted" style={{ display: 'flex', flexDirection: 'column', gap: '1rem', listStyle: 'none', color: 'var(--text-muted)' }}>
                <li><a href="#" className="hover:text-primary">Marketplace</a></li>
                <li><a href="#" className="hover:text-primary">Creator Hub</a></li>
                <li><a href="#" className="hover:text-primary">Explore Art</a></li>
              </ul>
            </div>
            
            <div>
              <h4 className="text-lg mb-6" style={{ marginBottom: '1.5rem' }}>Company</h4>
              <ul className="flex flex-col gap-4 text-muted" style={{ display: 'flex', flexDirection: 'column', gap: '1rem', listStyle: 'none', color: 'var(--text-muted)' }}>
                <li><a href="#" className="hover:text-primary">Our Story</a></li>
                <li><a href="#" className="hover:text-primary">Roadmap</a></li>
                <li><a href="#" className="hover:text-primary">Contact</a></li>
              </ul>
            </div>
            
            <div>
              <h4 className="text-lg mb-6" style={{ marginBottom: '1.5rem' }}>Stay Updated</h4>
              <div className="flex gap-2 mb-8" style={{ display: 'flex', gap: '0.5rem', marginBottom: '2rem' }}>
                {[Twitter, Instagram, Github].map((Icon, i) => (
                  <button key={i} className="p-3 rounded-xl bg-offset hover:text-primary transition-all" style={{ padding: '0.75rem', background: 'var(--bg-offset)', borderRadius: '0.75rem' }}>
                    <Icon size={20} />
                  </button>
                ))}
              </div>
              <div className="relative" style={{ position: 'relative' }}>
                <input 
                  type="text" 
                  placeholder="Your Email" 
                  className="w-full bg-offset border border-border rounded-full py-4 px-6 focus:outline-none focus:border-primary transition-all"
                  style={{ width: '100%', background: 'var(--bg-offset)', border: '1.5px solid var(--border)', borderRadius: '50px', padding: '1rem 1.5rem' }}
                />
                <button className="absolute right-2 top-2 p-2 rounded-full bg-gradient text-white" style={{ position: 'absolute', right: '8px', top: '8px', padding: '8px', borderRadius: '50%' }}>
                  <ArrowRight size={20} />
                </button>
              </div>
            </div>
          </div>
          
          <div className="flex flex-col md:flex-row justify-between items-center pt-10 border-t border-border gap-4 text-xs text-muted" style={{ borderTop: '1.5px solid var(--border)', paddingTop: '2.5rem', display: 'flex', justifyContent: 'space-between', alignItems: 'center', fontSize: '0.75rem', color: 'var(--text-muted)' }}>
            <p>© 2026 Animazon. Built for the community.</p>
            <div className="flex gap-8" style={{ display: 'flex', gap: '2rem' }}>
              <a href="#">Privacy Policy</a>
              <a href="#">Terms of Service</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default App;
